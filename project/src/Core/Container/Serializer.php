<?php

namespace Core\Container;


/**
 * todo:много копипаста, нужна оптимизация на уровне Symfony
 * todo tothink is really need so complex and magic class
 * Class Serializer
 * @package Helpers
 */
class Serializer extends AbstractContainerItem
{

    /**
     * Обнулять параметрами из источника
     * @var bool $nullable
     */
    private $nullable = false;

    /**
     * Перезаписывать параметрами из источника
     * @var bool $rewritable
     */
    private $rewritable = false;

    /**
     * Добавлять параметрами источника, если субьект имеет, что-то у себя
     * @var bool
     */
    private $addable = true;

    /**
     * Десериализует данные
     * @param $source
     * @param $subject
     * @return mixed
     */
    public function normalize($source, $subject = null)
    {
        switch(true) {
            case \is_object($subject):
                switch(true) {
                    /**
                     * object -> object
                     */
                    case \is_object($source) && $source instanceOf PropertyAccessInterface:
                        foreach($source->getProperties() as $property) {
                            $setMethod = $this->setMethod($property);
                            $addMethod = $this->addMethod($property);
                            $getMethod = $this->getMethod($property);
                            /**
                             * Добавляет элементы если свойство в объекте - это массив
                             */
                            if(method_exists($source, $getMethod) &&
                                \is_array($source->$getMethod()) &&
                                method_exists($subject, $addMethod)
                            ) {
                                if($this->addable === false && \count($source->$getMethod()) > 0) {
                                    continue;
                                }
                                foreach($source->$getMethod() as $subValue) {
                                    $subject->$addMethod($subValue);
                                }
                                continue;
                            }
                            /**
                             * Рекурсивно вызывается,если св-во subject является обьектом
                             */
                            if(method_exists($source, $getMethod) &&
                                method_exists($subject, $getMethod) &&
                                \is_object($subject->$getMethod()) &&
                                (\is_array($source->$getMethod()) || \is_object($source->$getMethod()))
                            ) {
                                $this->normalize($source->$getMethod(), $subject->$getMethod());
                                continue;
                            }
                            /**
                             * Простой сет свойства, если они совпадают по имени
                             */
                            if(method_exists($subject, $setMethod)) {
                                if($this->nullable === false && $source->$getMethod() === null) {
                                    continue;
                                }
                                if($this->rewritable === false && $subject->$getMethod() !== null) {
                                    continue;
                                }
                                $subject->$setMethod($source->$getMethod());
                                continue;
                            }
                        }
                        break;
                    /**
                     * array -> object
                     */
                    case \is_array($source):
                        foreach($source as $key => $value) {
                            $setMethod = $this->setMethod($key);
                            $addMethod = $this->addMethod($key);
                            $getMethod = $this->getMethod($key);
                            /**
                             */
                            if(\is_array($value) && method_exists($subject, $addMethod)) {
                                if($this->addable === false && \count($value) > 0) {
                                    continue;
                                }
                                foreach($value as $subValue) {
                                    $subject->$addMethod($subValue);
                                }
                                continue;
                            }
                            /**
                             * Рекурсивно вызывается,если св-во subject является обьектом
                             */
                            if((\is_array($value) || \is_object($value)) &&
                                method_exists($subject, $getMethod) &&
                                \is_object($subject->$getMethod())
                            ) {
                                $this->normalize($value, $subject->$getMethod($value));
                                continue;
                            }
                            /**
                             * Простой сет свойства, если они совпадают по имени
                             */
                            if(method_exists($subject, $setMethod)) {
                                if($this->nullable === false && $value === null) {
                                    continue;
                                }
                                if($this->rewritable === false && $subject->$getMethod() !== null) {
                                    continue;
                                }
                                $subject->$setMethod($value);
                                continue;
                            }
                        }
                        break;
                    /**
                     * json -> object
                     */
                    case $this->is_json($source):
                        $this->normalize(json_decode($source, true), $subject);
                        break;
                }
                break;
            case \is_string($subject):
                if(class_exists($subject)) {
                    $subject = $this->normalize($source, new $subject());
                }
                break;
            case \is_array($subject) || $subject === null:
                switch(true) {
                    /**
                     * object -> array
                     */
                    case \is_object($source) && $source instanceOf PropertyAccessInterface:
                        if($subject === null){
                            $subject = [];
                        }
                        foreach($source->getProperties() as $property) {
                            if(!array_key_exists($property,$subject)){
                                $subject[$property] = null;
                            }
                            $getMethod = $this->getMethod($property);

                            if(\is_array($source->$getMethod())) {

                                if(!empty($subject[$property])){
                                    if($this->addable === false && \count($source->$getMethod()) > 0) {
                                        continue;
                                    }
                                    $subject[$property] = array_merge($source->$getMethod(),$subject[$property]);
                                }else{
                                    $subject[$property] = $source->$getMethod();
                                }
                                continue;
                            }
                            /**
                             * Рекурсивно вызывается,если св-во subject является обьектом
                             */
                            if(method_exists($source, $getMethod) &&
                                (\is_array($source->$getMethod()) || \is_object($source->$getMethod()))
                            ) {
                                $subject[$property] = $this->normalize($source->$getMethod(), $subject[$property]);
                                continue;
                            }
                            /**
                             * Простой сет свойства, если они совпадают по имени
                             */
                            if($this->nullable === false && $source->$getMethod() === null) {
                                continue;
                            }
                            if($this->rewritable === false && $subject[$property] !== null) {
                                continue;
                            }
                            $subject[$property] = $source->$getMethod();
                            continue;
                        }
                        break;
                    /**
                     * array -> array
                     */
                    case \is_array($source):
                        foreach($source as $key => $element) {
                            $subject[$key] = $this->normalize($element);
                        }
                        break;
                    /**
                     * array -> json
                     */
                    case !\is_object($source) && $this->is_json($source):
                        $subject = json_decode($source, true);
                        break;
                }
                break;
        }


        return $subject;
    }

    /**
     * @param $source
     * @param string $type
     * @return mixed
     */
    public function serialize($source, string $type = 'json')
    {
        switch(true) {
            case \is_object($source) && $source instanceOf PropertyAccessInterface:
                $source = $this->normalize($source);
            case \is_array($source):
                if($type === 'json') {
                    $source = json_encode($source, true);
                }
                break;
        }

        return $source;
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
     * @param $data
     * @return bool
     */
    private function is_json($data): bool
    {
        json_decode($data);

        return (json_last_error() === JSON_ERROR_NONE);
    }

    /**
     * @param bool $nullable
     */
    public function setNullable(bool $nullable): void
    {
        $this->nullable = $nullable;
    }

    /**
     * @param bool $rewritable
     */
    public function setRewritable(bool $rewritable): void
    {
        $this->rewritable = $rewritable;
    }

    /**
     * @param bool $addable
     */
    public function setAddable(bool $addable): void
    {
        $this->addable = $addable;
    }

    public function init(): void
    {
        // TODO: Implement init() method.
    }
}