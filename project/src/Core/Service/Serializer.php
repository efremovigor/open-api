<?php

namespace Core\Service;

use Core\Service\Entity\ContainsCollectionInterface;
use Core\Service\Entity\PropertyAccessInterface;


/**
 * todo tothink is really need so complex and magic class
 * Class Serializer
 * @package Helpers
 */
class Serializer
{

    /**
     * nullable - Обнулять параметрами из источника
     * rewritable - Перезаписывать параметрами из источника
     * addable - Добавлять параметрами источника, если субьект имеет, что-то у себя
     * camel_force - Превращает ключи в camelCase
     */
    public const ADDABLE = 0b0000001;
    public const REWRITABLE = 0b0000010;
    public const NULLABLE = 0b0000100;
    public const CAMEL_FORCE = 0b0001000;
    public const SERIALIZE_FILLED = 0b0010000;

    /**
     * Десериализует данные
     * @param       $source
     * @param       $subject
     * @param int $flags
     * @return mixed
     * @throws \Exception
     */
    public function normalize($source, $subject = null, int $flags = self::ADDABLE)
    {
        switch (true) {
            case \is_object($subject):
                switch (true) {
                    /** object -> object{PropertyAccessInterface} */
                    case $source instanceOf PropertyAccessInterface:
                        $this->objectToObject($source, $subject, $flags);
                        break;
                    /** object -> object{ContainsCollectionInterface} */
                    case $subject instanceOf ContainsCollectionInterface && $source instanceOf ContainsCollectionInterface:
                        $this->collectionToCollection($source, $subject, $flags);
                        break;
                    /**
                     * array -> collection object
                     * array -> object
                     */
                    case \is_array($source):
                        if ($subject instanceOf ContainsCollectionInterface) {
                            $this->arrayToCollectionObject($source, $subject, $flags);
                        } else {
                            $this->arrayToObject($source, $subject, $flags);
                        }
                        break;
                    /** json -> object */
                    case $this->isJson($source):
                        $this->normalize(json_decode($source, true), $subject, $flags);
                        break;
                }
                break;
            /** Создает класс по имени и рекурсивно вызываем */
            case \is_string($subject):
                if (class_exists($subject)) {
                    $subject = $this->normalize($source, new $subject(), $flags);
                }
                break;
            case \is_array($subject) || $subject === null:
                switch (true) {
                    /**
                     * Если обьект преобразования коллекция
                     * Подменяем сорс внутренними элементами
                     */
                    case  \is_object($source) && $source instanceof ContainsCollectionInterface:
                        $subject = $this->normalize($source->getElements(), $subject, $flags);
                        break;
                    /** array -> array */
                    case \is_array($source):
                        foreach ($source as $key => $element) {
                            /** Если элемент массива - массив, и он определен в субьекте - то лезем внутрь */
                            if (\is_array($element) && isset($subject[$key])) {
                                $subject[$key] = $this->normalize($element, $subject[$key], $flags);
                                /** если внутри массива обьект */
                            } elseif (\is_object($element) && $element instanceOf PropertyAccessInterface) {
                                $subject[$key] = $this->normalize($element, [], $flags);
                                /** стандартное поведение */
                            } else {
                                $subject[$key] = $element;
                            }
                        }
                        break;
                    /** object -> array */
                    case \is_object($source) && $source instanceOf PropertyAccessInterface:
                        if ($subject === null) {
                            $subject = [];
                        }
                        $this->objectToArray($source, $subject, $flags);
                        break;
                    /** array -> json */
                    case !\is_object($source) && $this->isJson($source):
                        $subject = json_decode($source, true);
                        break;
                }
                break;
        }


        return $subject;
    }

    /**
     * @param        $source
     * @param string $type
     * @param int $flags
     * @return mixed
     * @throws \Exception
     */
    public function serialize($source, string $type = 'json', int $flags = 0)
    {
        switch (true) {
            /**
             * превращаем в массив, и проваливаемся в следующий кейс.
             */
            case \is_object(
                    $source
                ) && ($source instanceOf PropertyAccessInterface || $source instanceOf ContainsCollectionInterface):
                $source = $this->normalize($source);
            case \is_array($source):
                if ($this->isSerializeFilled($flags)) {
                    $source = $this->arrayFilterRecursive($source, function ($el) {
                        return $el !== null;
                    });
                    if (count($source) === 0) {
                        return null;
                    }
                }
                if ($type === 'json') {
                    $source = json_encode($source, true);
                }
                break;
        }

        return $source;
    }

    /**
     * @param $source
     * @param int $flags
     * @return mixed
     * @throws \Exception
     */
    public function jsonSignificant($source, int $flags = Serializer::SERIALIZE_FILLED)
    {
        return $this->serialize($source, 'json', $flags);
    }

    /**
     * Циклом нормализует данные в обьекте(кеп)
     * @param array $source
     * @param ContainsCollectionInterface $subject
     * @throws \Exception
     * @param $flags
     */
    private function arrayToCollectionObject(array $source, ContainsCollectionInterface $subject, $flags): void
    {
        foreach ($source as $key => $property) {
            $subject->set($key, $this->normalize($property, $subject->getClass(), $flags));
        }
    }

    /**
     * Переливает обьект в обьект
     * @param PropertyAccessInterface $source
     * @param mixed $subject
     * @param int $flags
     * @return void
     * @throws \Exception
     */
    private function objectToObject(PropertyAccessInterface $source, &$subject, int $flags = self::ADDABLE): void
    {
        foreach ($source->getProperties() as $property) {
            if ($this->isCamelForce($flags)) {
                $property = $this->toCamel($property);
            }
            $setMethod = $this->setMethod($property);
            $addMethod = $this->addMethod($property);
            $sourceGetter = $this->getExistingGetter($source, $property);
            $subjectGetter = $this->getExistingGetter($subject, $property, true);

            /**
             * Добавляет элементы если свойство в объекте - это массив
             */
            if (\is_array($source->$sourceGetter()) &&
                method_exists($subject, $addMethod)) {
                if ($this->isAddable($flags) === false && \count($source->$sourceGetter()) > 0) {
                    continue;
                }

                foreach ((array) $source->$sourceGetter() as $subValue) {
                    $subject->$addMethod($subValue);
                }
                continue;
            }
            /**
             * Рекурсивно вызывается,если св-во subject является обьектом
             */
            if (method_exists($source, $sourceGetter) &&
                method_exists($subject, $subjectGetter) &&
                \is_object($subject->$subjectGetter()) &&
                (\is_array($source->$sourceGetter()) || \is_object($source->$sourceGetter()))
            ) {
                $this->normalize($source->$sourceGetter(), $subject->$subjectGetter(), $flags);
                continue;
            }
            /**
             * Простой сет свойства, если они совпадают по имени
             */
            if (method_exists($subject, $setMethod) && $subjectGetter !== null) {
                if ($this->isNullable($flags) === false && $source->$sourceGetter() === null) {
                    continue;
                }
                if ($this->isRewritable($flags) === false && $subject->$subjectGetter() !== null) {
                    continue;
                }
                $subject->$setMethod($source->$sourceGetter());
                continue;
            }
        }
    }

    /**
     * @param array $source
     * @param mixed $subject
     * @param int $flags
     * @throws \Exception
     */
    private function arrayToObject(array $source, &$subject, int $flags = self::ADDABLE): void
    {
        foreach ($source as $key => $value) {
            if ($this->isCamelForce($flags)) {
                $key = $this->toCamel($key);
            }
            $setMethod = $this->setMethod($key);
            $addMethod = $this->addMethod($key);
            $subjectGetter = $this->getExistingGetter($subject, $key, true);

            /**
             * Если элемент сорса массив , а элемент того уровня коллекция - упаковываем в коллекцию
             */
            if (\is_array($value) && $subjectGetter !== null && $subject->$subjectGetter() instanceof ContainsCollectionInterface) {
                foreach ((array) $value as $subKey => $subValue) {
                    $subject->$subjectGetter()->set($subKey, $this->normalize($subValue, $subject->$subjectGetter()->getClass(), $flags));
                }
                continue;
            }

            /**
             */
            if (\is_array($value) && method_exists($subject, $addMethod)) {
                if ($this->isAddable($flags) === false && \count($value) > 0) {
                    continue;
                }
                foreach ($value as $subValue) {
                    $subject->$addMethod($subValue);
                }
                continue;
            }
            /**
             * Рекурсивно вызывается,если св-во subject является обьектом
             */
            if ((\is_array($value) || \is_object($value)) && $subjectGetter !== null &&
                \is_object($subject->$subjectGetter())
            ) {
                $this->normalize($value, $subject->$subjectGetter($value), $flags);
                continue;
            }
            /**
             * Простой сет свойства, если они совпадают по имени
             */
            if (method_exists($subject, $setMethod)) {
                if ($value === null && $this->isNullable($flags) === false) {
                    continue;
                }
                if ($this->isRewritable($flags) === false && $subject->$subjectGetter() !== null) {
                    continue;
                }
                $subject->$setMethod($value);
                continue;
            }
        }
    }

    /**
     * @param PropertyAccessInterface $source
     * @param array $subject
     * @param int $flags
     * @throws \Exception
     */
    private function objectToArray(PropertyAccessInterface $source, array &$subject = [], int $flags = self::ADDABLE): void
    {
        foreach ($source->getProperties() as $property) {
            if (!array_key_exists($property, $subject)) {
                $subject[$property] = null;
            }
            $getMethod = $this->getExistingGetter($source, $property);

            if (\is_array($source->$getMethod())) {

                /**
                 * Разбор ситуации если свойство обьекта массив в котором могут быть обьекты
                 */
                $sourceData = $source->$getMethod();
                /**
                 * $fakeSubject не пуст если внутри $sourceData лежат обьекты
                 */
                $fakeSubject = [];
                foreach ($sourceData as $key => &$data) {
                    if (\is_object($data) && $data instanceof PropertyAccessInterface) {
                        $fakeSubject[$key] = [];
                        $this->objectToArray($data, $fakeSubject[$key]);
                    }
                }
                $sourceData = array_replace($sourceData, $fakeSubject);

                /**
                 * Если субьект заполнен и есть разрешение
                 */
                if (!empty($subject[$property])) {
                    if ($this->isAddable($flags) === false && \count($sourceData) > 0) {
                        continue;
                    }
                    $subject[$property] = array_merge($sourceData, $subject[$property]);
                } else {
                    $subject[$property] = array_merge($sourceData);
                }
                continue;
            }
            /**
             * Рекурсивно вызывается,если св-во subject является обьектом
             */
            if (method_exists($source, $getMethod) &&
                (\is_array($source->$getMethod()) || \is_object($source->$getMethod()))
            ) {
                $subject[$property] = $this->normalize($source->$getMethod(), $subject[$property], $flags);
                continue;
            }
            /**
             * Простой сет свойства, если они совпадают по имени
             */
            if ($this->isNullable($flags) === false && $source->$getMethod() === null) {
                continue;
            }
            if ($subject[$property] !== null && $this->isRewritable($flags) === false) {
                continue;
            }
            $subject[$property] = $source->$getMethod();
            continue;
        }
    }

    /**
     * @param $key
     *
     * @return string
     */
    protected function setMethod(string $key): string
    {
        return 'set' . ucfirst($key);
    }

    /**
     * @param $key
     *
     * @return string
     */
    protected function getMethod(string $key): string
    {
        return 'get' . ucfirst($key);
    }

    /**
     * @param $key
     *
     * @return string
     */
    protected function addMethod(string $key): string
    {
        return 'add' . ucfirst($key);
    }


    /**
     * @param string $key
     * @return string
     */
    private function isMethod(string $key): string
    {
        return preg_match('/^is[A-Z].+/', $key) ? $key : 'is' . ucfirst($key);
    }

    /**
     * @param $source
     * @param string $key
     * @param bool $force
     * @return string
     * @throws \Exception
     */
    private function getExistingGetter($source, string $key, bool $force = false): ?string
    {
        switch (true) {
            case method_exists($source, $this->isMethod($key)):
                return $this->isMethod($key);
            case method_exists($source, $this->getMethod($key)):
                return $this->getMethod($key);
            case $force === true:
                return null;
        }
        throw new \Exception(\sprintf('Getter for %s not exists', $key));
    }

    /**
     * @param $data
     * @return bool
     */
    private function isJson($data): bool
    {
        json_decode($data);

        return (json_last_error() === JSON_ERROR_NONE);
    }

    /**
     * @param int $flags
     * @return bool
     */
    private function isNullable(int $flags): bool
    {
        return (bool) (static::NULLABLE & $flags);
    }

    /**
     * @param int $flags
     * @return bool
     */
    private function isRewritable(int $flags): bool
    {
        return (bool) (static::REWRITABLE & $flags);
    }

    /**
     * @param int $flags
     * @return bool
     */
    private function isAddable(int $flags): bool
    {
        return (bool) (static::ADDABLE & $flags);
    }

    /**
     * @param int $flags
     * @return bool
     */
    private function isCamelForce(int $flags): bool
    {
        return (bool) (static::CAMEL_FORCE & $flags);
    }

    /**
     * @param int $flags
     * @return bool
     */
    private function isSerializeFilled(int $flags): bool
    {
        return (bool) (static::SERIALIZE_FILLED & $flags);
    }

    /**
     * @param string $string
     * @return string
     */
    private function toCamel(string $string): string
    {
        $string = str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $string)));
        strtolower($string[0]);

        return $string;
    }

    /**
     * @param array $array
     * @param callable|null $callback
     * @return array
     */
    private function arrayFilterRecursive(array $array, callable $callback = null): array
    {
        $array = is_callable($callback) ? array_filter($array, $callback) : array_filter($array);
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                $value = $this->arrayFilterRecursive($value, $callback);
                if (count($value) === 0) {
                    unset($array[$key]);
                }
            }
        }

        return $array;
    }

    /**
     * @param ContainsCollectionInterface $source
     * @param ContainsCollectionInterface $subject
     * @param int $flags
     */
    private function collectionToCollection(ContainsCollectionInterface $source, ContainsCollectionInterface $subject, int $flags)
    {
        $count = count($subject->getElements());
        if ($count > 0 && !$this->isAddable($flags)) {
            return;
        }

        foreach ($source->getElements() as $element) {
            /**
             * Если определён способ как сохранять брать его, иначе брать инкремент количества ( set - может переопределит $key в листе)
             */
            $subject->set($element instanceof CollectionKeyInterface ? $element->getCollectionKey() : ++$count, $element);
        }
    }
}