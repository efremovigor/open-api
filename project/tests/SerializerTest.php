<?php

namespace AutoTest\Core\Helper;

use Core\Service\Entity\PropertyAccessInterface;
use Core\Service\Serializer;
use PHPUnit_Framework_TestCase;

class SerializerTest extends PHPUnit_Framework_TestCase
{

    private $serializer;

    public function __construct(string $name = null, array $data = [], string $dataName = '')
    {
        $this->serializer = new Serializer();
        parent::__construct($name, $data, $dataName);
    }

    /**
     * Тест обычного заполнение сущности массивом
     * @throws \Exception
     */
    public function testNormalizeArray(): void
    {
        $fixture = ['a' => 'a1', 'b' => ['b1', 'b2', 'b3'], 'c' => ['f' => 'f1'], 'x' => true, 'noExistField' => 'fuck'];
        $object  = $this->getAnonymousObject();
        $this->assertEquals($object->getA(), null);
        $this->assertEquals($object->getB(), null);
        $this->assertEquals($object->getC()->getF(), null);
        $this->assertEquals($object->isX(), null);
        $object = $this->serializer->normalize($fixture, $object);
        $this->assertEquals($object->getA(), $fixture['a']);
        $this->assertEquals($object->getB(), $fixture['b']);
        $this->assertEquals($object->getC()->getF(), $fixture['c']['f']);
        $this->assertEquals($object->isX(), $fixture['x']);
    }

    /**
     * Тест обычного заполнение сущности другой сущностью
     * @throws \Exception
     */
    public function testNormalizeObject(): void
    {
        $object1 = $this->getAnonymousObject();
        $object1->setA('a1');
        $object1->addB('b1');
        $object1->addB('b2');
        $object1->addB('b3');
        $object1->getC()->setF('f1');
        $object1->setX(true);
        $object2 = $this->getAnonymousObject();
        $object2 = $this->serializer->normalize($object1, $object2);
        $this->assertEquals($object2->getA(), 'a1');
        $this->assertEquals($object2->getB(), ['b1', 'b2', 'b3']);
        $this->assertEquals($object2->getC()->getF(), 'f1');
        $this->assertEquals($object2->isX(), true);
    }

    /**
     * Тест заполнение сущности другой сущностью с обнулением параметров
     * @throws \Exception
     */
    public function testNormalizeObjectNullable(): void
    {
        $object1 = $this->getAnonymousObject();
        $object2 = $this->getAnonymousObject();
        $object2->setA('a1');
        $object2->getC()->setF('f1');
        $object2->addB('b1');
        $object2->addB('b2');
        $object2->addB('b3');
        $object2->setX(true);
        $object2 = $this->serializer->normalize($object1, $object2);
        $this->assertEquals($object2->getA(), 'a1');
        $this->assertEquals($object2->getB(), ['b1', 'b2', 'b3']);
        $this->assertEquals($object2->getC()->getF(), 'f1');
        $this->assertEquals($object2->isX(), true);

        $object2 = $this->getAnonymousObject();
        $object2->setA('a1');
        $object2->addB('b1');
        $object2->addB('b2');
        $object2->addB('b3');
        $object2->getC()->setF('f1');
        $object2 = $this->serializer->normalize($object1, $object2, Serializer::NULLABLE | Serializer::REWRITABLE);
        $this->assertEquals($object2->getA(), null);
        $this->assertEquals($object2->getB(), null);
        $this->assertEquals($object2->getC()->getF(), null);
        $this->assertEquals($object2->isX(), null);
    }

    /**
     * Тест заполнение сущности массивом с обнулением параметров
     */
    public function testNormalizeArrayNullable(): void
    {
        $fixture = ['a' => null, 'b' => ['b1', 'b2', 'b3'], 'c' => ['f' => null], 'x' => null];
        $object  = $this->getAnonymousObject();
        $object->setA('a1');
        $object->getC()->setF('f1');
        $object->setX(true);
        $object = $this->serializer->normalize($fixture, $object);
        $this->assertEquals($object->getA(), 'a1');
        $this->assertEquals($object->getB(), $fixture['b']);
        $this->assertEquals($object->getC()->getF(), 'f1');
        $this->assertEquals($object->isX(), true);

        $object = $this->getAnonymousObject();
        $object->setA('a1');
        $object->addB('b1');
        $object->addB('b2');
        $object->addB('b3');
        $object->getC()->setF('f1');
        $object = $this->serializer->normalize(['a' => null, 'b' => null, 'c' => ['f' => null]], $object, Serializer::NULLABLE | Serializer::REWRITABLE);
        $this->assertEquals($object->getA(), null);
        $this->assertEquals($object->getB(), null);
        $this->assertEquals($object->getC()->getF(), null);
        $this->assertEquals($object->isX(), null);

    }

    /**
     * Тест параметра добавления данных в коллекции (обьектом)
     */
    public function testNormalizeObjectAddable(): void
    {
        $object1 = $this->getAnonymousObject();
        $object1->addB('b2');
        $object2 = $this->getAnonymousObject();
        $object2->addB('b1');

        $object2 = $this->serializer->normalize($object1, $object2, 0);
        $this->assertEquals($object2->getB(), ['b1']);

        $object2 = $this->serializer->normalize($object1, $object2);
        $this->assertEquals($object2->getB(), ['b1', 'b2']);
    }

    /**
     * Тест параметра добавления данных в коллекции (массивом)
     */
    public function testNormalizeArrayAddable(): void
    {
        $fixture = ['b' => ['b1', 'b2', 'b3']];
        $object2 = $this->getAnonymousObject();
        $object2->addB('b1');

        $object2 = $this->serializer->normalize($fixture, $object2, 0);
        $this->assertEquals($object2->getB(), ['b1']);

        $object2 = $this->serializer->normalize($fixture, $object2);
        $this->assertEquals($object2->getB(), ['b1', 'b1', 'b2', 'b3']);
    }

    public function testNormalizeJsonToObject(): void
    {
        $json   = '{"a":"a1","b":["b1","b2","b3"],"c":{"f":"f1"},"x":true}';
        $object = $this->getAnonymousObject();
        $object = $this->serializer->normalize($json, $object);
        $this->assertEquals($object->getA(), 'a1');
        $this->assertEquals($object->getB(), ['b1', 'b2', 'b3']);
        $this->assertEquals($object->getC()->getF(), 'f1');
        $this->assertEquals($object->isX(), true);
    }

    /**
     * @throws \Exception
     */
    public function testNormalizeObjectToArray(): void
    {
        $object = $this->getAnonymousObject();
        $object->setA('a1');
        $object->addB('b1');
        $object->addB('b2');
        $object->addB('b3');
        $object->setX(true);
        $object->getC()->setF('f1');
        $object2 = $this->serializer->normalize($object);
        $this->assertEquals($object2['a'], 'a1');
        $this->assertEquals($object2['b'], ['b1', 'b2', 'b3']);
        $this->assertEquals($object2['c']['f'], 'f1');
        $this->assertEquals($object2['x'], true);
    }

    public function testNormalizeObjectToArrayFullRewrite(): void
    {
        $object = $this->getAnonymousObject();
        $object->setA('a1');
        $object->addB('b1');
        $object->addB('b2');
        $object->addB('b3');
        $object->getC()->setF('f1');
        $object->setX(true);
        $object2 = $this->serializer->normalize($object, ['a' => 'a2', 'b' => ['b4'], 'c' => ['f' => 'f8'], 'x' => false], Serializer::ADDABLE | Serializer::REWRITABLE);
        $this->assertEquals($object2['a'], 'a1');
        $this->assertEquals($object2['b'], ['b1', 'b2', 'b3', 'b4']);
        $this->assertEquals($object2['c']['f'], 'f1');
        $this->assertEquals($object2['x'], true);
    }

    public function testNormalizeObjectToArrayFullNull(): void
    {
        $object  = $this->getAnonymousObject();
        $object2 = $this->serializer->normalize($object, ['a' => 'a1', 'b' => ['b1', 'b2', 'b3', 'b4'], 'c' => ['f' => 'f1'], 'x' => true], Serializer::REWRITABLE);
        $this->assertEquals($object2['a'], 'a1');
        $this->assertEquals($object2['b'], ['b1', 'b2', 'b3', 'b4']);
        $this->assertEquals($object2['c']['f'], 'f1');
        $this->assertEquals($object2['x'], true);
        $object2 = $this->serializer->normalize($object, ['a' => 'a1', 'b' => ['b1', 'b2', 'b3', 'b4'], 'c' => ['f' => 'f1']], Serializer::NULLABLE | Serializer::REWRITABLE);
        $this->assertEquals($object2['a'], null);
        $this->assertEquals($object2['b'], null);
        $this->assertEquals($object2['c']['f'], null);
        $this->assertEquals($object2['x'], null);
    }

    public function testSerializeObjectToJson(): void
    {
        $object = $this->getAnonymousObject();
        $object->setA('a1');
        $object->addB('b1');
        $object->addB('b2');
        $object->addB('b3');
        $object->getC()->setF('f1');
        $object->setX(true);
        $json = $this->serializer->serialize($object);
        $this->assertEquals('{"a":"a1","b":["b1","b2","b3"],"c":{"f":"f1"},"x":true}', $json);
    }

    public function testSerializeArrayToJson(): void
    {
        $json = $this->serializer->serialize(
            ['a' => 'a1', 'b' => ['b1', 'b2', 'b3', 'b4'], 'c' => ['f' => 'f1'], 'x' => false]
        );
        $this->assertEquals('{"a":"a1","b":["b1","b2","b3","b4"],"c":{"f":"f1"},"x":false}', $json);
    }

    /**
     * @throws \Exception
     */
    public function testNormalizeJsonToClass(): void
    {
        $object = $this->serializer->normalize(
            '{"a":"a1","b":["b1","b2","b3","b4"],"c":{"f":"f1"},"x":true}',
            TestClass::class
        );
        $this->assertEquals($object->getA(), 'a1');
        $this->assertEquals($object->getB(), ['b1', 'b2', 'b3', 'b4']);
        $this->assertEquals($object->getC()->getF(), 'f1');
        $this->assertEquals($object->isX(), true);
    }

    public function testSerializeComplexObjectToJson(): void
    {
        $object1 = $this->getAnonymousObject();
        $object2 = $this->getAnonymousObject();
        $object3 = $this->getAnonymousObject();

        $object1->setA('a1');
        $object1->addB($object2);
        $object1->getC()->setF('f1');

        $object2->setA('a2');
        $object2->addB($object3);
        $object2->addB('b21');
        $object2->addB('b21');
        $object2->addB('b21');
        $object2->addB('b21');
        $object2->getC()->setF('f2');
        $object2->setX(false);


        $object3->setA('a3');
        $object3->addB('b31');
        $object3->addB('b31');
        $object3->addB('b31');
        $object3->addB('b31');
        $object3->getC()->setF('f3');
        $object3->setX(true);

        $json = $this->serializer->serialize($object1);
        $this->assertEquals(
            '{"a":"a1","b":[{"a":"a2","b":[{"a":"a3","b":["b31","b31","b31","b31"],"c":{"f":"f3"},"x":true},"b21","b21","b21","b21"],"c":{"f":"f2"},"x":false}],"c":{"f":"f1"},"x":null}',
            $json
        );
    }

    /**
     * @throws \Exception
     */
    public function testSerializeWithFlagSerializeFilled()
    {
        $fixture = ['a' => 'a1', 'b' => ['b1' => null, 'b2', 'b3' => null, 'b4'], 'c' => ['f' => null], 'x' => false, 'y' => true, 'n' => null];
        $json    = $this->serializer->serialize($fixture, 'json', Serializer::SERIALIZE_FILLED);
        $this->assertEquals($json, '{"a":"a1","b":["b2","b4"],"x":false,"y":true}');
    }

    /**
     * @throws \Exception
     */
    public function testSerializeWithFlagSerializeFilledEmptyArray()
    {
        $fixture = [];
        $json    = $this->serializer->serialize($fixture, 'json', Serializer::SERIALIZE_FILLED);
        $this->assertEquals($json, null);
    }

    /**
     * @throws \Exception
     */
    public function testSerializeWithFlagSerializeFilledJson()
    {
        $fixture = '{"a":"a1","b":["b2","b4"],"x":false,"y":true}';
        $json    = $this->serializer->serialize($fixture, 'json', Serializer::SERIALIZE_FILLED);
        $this->assertEquals($json, $fixture);
    }

    /**
     * @return TestClass
     */
    private function getAnonymousObject(): TestClass
    {
        return new TestClass();
    }
}

class TestClass implements PropertyAccessInterface
{
    private $a;
    private $b;
    private $c;
    private $isX;

    public function __construct()
    {
        $class   = new class implements PropertyAccessInterface
        {
            private $f;

            public function getF()
            {
                return $this->f;
            }

            public function setF($f): void
            {
                $this->f = $f;
            }

            public function getProperties(): array
            {
                return ['f'];
            }
        };
        $this->c = new $class();
    }

    public function getA()
    {
        return $this->a;
    }

    public function setA($a): void
    {
        $this->a = $a;
    }

    public function getB()
    {
        return $this->b;
    }

    public function addB($b): void
    {
        $this->b[] = $b;
    }

    public function getC()
    {
        return $this->c;
    }

    public function setC($c): void
    {
        $this->c = $c;
    }

    public function getProperties(): array
    {
        return ['a', 'b', 'c', 'x'];
    }

    public function setB($b): void
    {
        $this->b = $b;
    }

    /**
     * @return mixed
     */
    public function isX()
    {
        return $this->isX;
    }

    /**
     * @param mixed $isX
     */
    public function setX($isX): void
    {
        $this->isX = $isX;
    }
}