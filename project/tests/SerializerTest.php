<?php

namespace AutoTest\Core\Helper;

use Core\AbstractList;
use Core\Service\Entity\CollectionKeyInterface;
use Core\Service\Entity\ContainsCollectionInterface;
use Core\Service\Entity\HasJsonPropertiesInterface;
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
        $fixture = ['a' => 'a1', 'b' => ['b1', 'b2', 'b3'], 'c' => ['f' => 'f1'], 'isX' => true, 'noExistField' => 'fuck'];
        $object  = $this->getAnonymousObject();
        $this->assertEquals($object->getA(), null);
        $this->assertEquals($object->getB(), null);
        $this->assertEquals($object->getC()->getF(), null);
        $this->assertEquals($object->isX(), null);
        $object = $this->serializer->normalize($fixture, $object);
        $this->assertEquals($object->getA(), $fixture['a']);
        $this->assertEquals($object->getB(), $fixture['b']);
        $this->assertEquals($object->getC()->getF(), $fixture['c']['f']);
        $this->assertEquals($object->isX(), $fixture['isX']);
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
        $object1->setIsX(true);
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
        $object2->setIsX(true);
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
        $fixture = ['a' => null, 'b' => ['b1', 'b2', 'b3'], 'c' => ['f' => null], 'isX' => null];
        $object  = $this->getAnonymousObject();
        $object->setA('a1');
        $object->getC()->setF('f1');
        $object->setIsX(true);
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
        $json   = '{"a":"a1","b":["b1","b2","b3"],"c":{"f":"f1"},"isX":true}';
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
        $object->setIsX(true);
        $object->getC()->setF('f1');
        $object2 = $this->serializer->normalize($object);
        $this->assertEquals($object2['a'], 'a1');
        $this->assertEquals($object2['b'], ['b1', 'b2', 'b3']);
        $this->assertEquals($object2['c']['f'], 'f1');
        $this->assertEquals($object2['isX'], true);
    }

    public function testNormalizeObjectToArrayFullRewrite(): void
    {
        $object = $this->getAnonymousObject();
        $object->setA('a1');
        $object->addB('b1');
        $object->addB('b2');
        $object->addB('b3');
        $object->getC()->setF('f1');
        $object->setIsX(true);
        $object2 = $this->serializer->normalize($object, ['a' => 'a2', 'b' => ['b4'], 'c' => ['f' => 'f8'], 'isX' => false], Serializer::ADDABLE | Serializer::REWRITABLE);
        $this->assertEquals($object2['a'], 'a1');
        $this->assertEquals($object2['b'], ['b1', 'b2', 'b3', 'b4']);
        $this->assertEquals($object2['c']['f'], 'f1');
        $this->assertEquals($object2['isX'], true);
    }

    public function testNormalizeObjectToArrayFullNull(): void
    {
        $object  = $this->getAnonymousObject();
        $object2 = $this->serializer->normalize($object, ['a' => 'a1', 'b' => ['b1', 'b2', 'b3', 'b4'], 'c' => ['f' => 'f1'], 'isX' => true], Serializer::REWRITABLE);
        $this->assertEquals($object2['a'], 'a1');
        $this->assertEquals($object2['b'], ['b1', 'b2', 'b3', 'b4']);
        $this->assertEquals($object2['c']['f'], 'f1');
        $this->assertEquals($object2['isX'], true);
        $object2 = $this->serializer->normalize($object, ['a' => 'a1', 'b' => ['b1', 'b2', 'b3', 'b4'], 'c' => ['f' => 'f1']], Serializer::NULLABLE | Serializer::REWRITABLE);
        $this->assertEquals($object2['a'], null);
        $this->assertEquals($object2['b'], null);
        $this->assertEquals($object2['c']['f'], null);
        $this->assertEquals($object2['isX'], null);
    }

    public function testSerializeObjectToJson(): void
    {
        $object = $this->getAnonymousObject();
        $object->setA('a1');
        $object->addB('b1');
        $object->addB('b2');
        $object->addB('b3');
        $object->getC()->setF('f1');
        $object->setIsX(true);
        $json = $this->serializer->serialize($object);
        $this->assertEquals('{"a":"a1","b":["b1","b2","b3"],"c":{"f":"f1"},"isX":true,"json":null}', $json);
    }

    public function testSerializeArrayToJson(): void
    {
        $json = $this->serializer->serialize(
            ['a' => 'a1', 'b' => ['b1', 'b2', 'b3', 'b4'], 'c' => ['f' => 'f1'], 'isX' => false]
        );
        $this->assertEquals('{"a":"a1","b":["b1","b2","b3","b4"],"c":{"f":"f1"},"isX":false}', $json);
    }

    /**
     * @throws \Exception
     */
    public function testNormalizeJsonToClass(): void
    {
        $object = $this->serializer->normalize(
            '{"a":"a1","b":["b1","b2","b3","b4"],"c":{"f":"f1"},"isX":true}',
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
        $object2->setIsX(false);


        $object3->setA('a3');
        $object3->addB('b31');
        $object3->addB('b31');
        $object3->addB('b31');
        $object3->addB('b31');
        $object3->getC()->setF('f3');
        $object3->setIsX(true);

        $json = $this->serializer->serialize($object1);
        $this->assertEquals(
            '{"a":"a1","b":[{"a":"a2","b":[{"a":"a3","b":["b31","b31","b31","b31"],"c":{"f":"f3"},"isX":true,"json":null},"b21","b21","b21","b21"],"c":{"f":"f2"},"isX":false,"json":null}],"c":{"f":"f1"},"isX":null,"json":null}',
            $json
        );
        $jsonFilled = $this->serializer->jsonSignificant($object1);
        $this->assertEquals(
            '{"a":"a1","b":[{"a":"a2","b":[{"a":"a3","b":["b31","b31","b31","b31"],"c":{"f":"f3"},"isX":true},"b21","b21","b21","b21"],"c":{"f":"f2"},"isX":false}],"c":{"f":"f1"}}',
            $jsonFilled
        );
    }

    /**
     * @throws \Exception
     */
    public function testSerializeWithFlagSerializeFilled()
    {
        $fixture = ['a' => 'a1', 'b' => ['b1' => null, 'b2', 'b3' => null, 'b4'], 'c' => ['f' => null], 'isX' => false, 'y' => true, 'n' => null];
        $json    = $this->serializer->serialize($fixture, 'json', Serializer::ONLY_FILLED);
        $this->assertEquals($json, '{"a":"a1","b":["b2","b4"],"isX":false,"y":true}');
    }

    /**
     * @throws \Exception
     */
    public function testSerializeWithFlagSerializeFilledEmptyArray()
    {
        $fixture = [];
        $json    = $this->serializer->serialize($fixture, 'json', Serializer::ONLY_FILLED);
        $this->assertEquals($json, null);
    }

    /**
     * @throws \Exception
     */
    public function testSerializeWithFlagSerializeFilledJson()
    {
        $fixture = '{"a":"a1","b":["b2","b4"],"isX":false,"y":true}';
        $json    = $this->serializer->serialize($fixture, 'json', Serializer::ONLY_FILLED);
        $this->assertEquals($json, $fixture);
    }

    public function testDefaultBehavior()
    {
        $this->assertNull($this->serializer->serialize(null, true));
        $this->assertNull($this->serializer->normalize(null, true));
        $this->assertNull($this->serializer->normalize(null, []));
        $this->assertNull($this->serializer->normalize(null, 0));
        $this->assertNull($this->serializer->normalize(null, 111));
        $this->assertNull($this->serializer->normalize(null, '0'));
        $this->assertNull($this->serializer->normalize(null, 'fuck'));

        $this->assertTrue($this->serializer->normalize(true, true));
        $this->assertTrue($this->serializer->normalize(true, null));
        $this->assertTrue($this->serializer->normalize(true, false));
        $this->assertTrue($this->serializer->normalize(true, ''));
        $this->assertTrue($this->serializer->normalize(true, []));
        $this->assertTrue($this->serializer->normalize(true, []));
        $this->assertTrue($this->serializer->normalize(true, []));
        $this->assertTrue($this->serializer->normalize(true, []));

        $this->assertFalse($this->serializer->normalize(false, null));
        $this->assertFalse($this->serializer->normalize(false, false));
        $this->assertFalse($this->serializer->normalize(false, ''));
        $this->assertFalse($this->serializer->normalize(false, []));
        $this->assertFalse($this->serializer->normalize(false, []));
        $this->assertFalse($this->serializer->normalize(false, []));
        $this->assertFalse($this->serializer->normalize(false, []));

        $this->assertEquals('', $this->serializer->normalize('', ''));
        $this->assertEquals('', $this->serializer->normalize('', null));
        $this->assertEquals('', $this->serializer->normalize('', true));
        $this->assertEquals('', $this->serializer->normalize('', false));
        $this->assertEquals('', $this->serializer->normalize('', []));

        $this->assertEquals([], $this->serializer->normalize([], true));
        $this->assertEquals([], $this->serializer->normalize([], false));
        $this->assertEquals([], $this->serializer->normalize([], null));
        $this->assertEquals([], $this->serializer->normalize([], []));


        $this->assertEquals(['keyFuck' => 'fuck1'], $this->serializer->normalize(['keyFuck' => 'fuck1'], []));
        $this->assertEquals(['keyFuck' => 'fuck1'], $this->serializer->normalize(['keyFuck' => 'fuck1'], true));
        $this->assertEquals(['keyFuck' => 'fuck1'], $this->serializer->normalize(['keyFuck' => 'fuck1'], false));
        $this->assertEquals(['keyFuck' => 'fuck1'], $this->serializer->normalize(['keyFuck' => 'fuck1'], null));
        $this->assertEquals(['keyFuck' => 'fuck1'], $this->serializer->normalize(['keyFuck' => 'fuck1'], ''));
        $this->assertEquals(['keyFuck' => 'fuck1'], $this->serializer->normalize(['keyFuck' => 'fuck1'], '0'));
        $this->assertEquals(['keyFuck' => 'fuck1'], $this->serializer->normalize(['keyFuck' => 'fuck1'], 'qwe'));
        $this->assertEquals(['keyFuck' => 'fuck1'], $this->serializer->normalize(['keyFuck' => 'fuck1'], 111));

        $this->assertEquals('0', $this->serializer->normalize('0', []));
        $this->assertEquals('0', $this->serializer->normalize('0', true));
        $this->assertEquals('0', $this->serializer->normalize('0', false));
        $this->assertEquals('0', $this->serializer->normalize('0', null));
        $this->assertEquals('0', $this->serializer->normalize('0', '0'));

        $this->assertEquals(0, $this->serializer->normalize(0, '0'));
        $this->assertEquals(0, $this->serializer->normalize(0, true));
        $this->assertEquals(0, $this->serializer->normalize(0, false));
        $this->assertEquals(0, $this->serializer->normalize(0, null));
        $this->assertEquals(0, $this->serializer->normalize(0, []));

        $this->assertEquals(1212, $this->serializer->normalize(1212, '1212'));
        $this->assertEquals(1212, $this->serializer->normalize(1212, true));
        $this->assertEquals(1212, $this->serializer->normalize(1212, false));
        $this->assertEquals(1212, $this->serializer->normalize(1212, null));
        $this->assertEquals(1212, $this->serializer->normalize(1212, []));

        $this->assertEquals(new \stdClass(), $this->serializer->normalize(new \stdClass(), true));
        $this->assertEquals(new \stdClass(), $this->serializer->normalize(new \stdClass(), false));
        $this->assertEquals(new \stdClass(), $this->serializer->normalize(new \stdClass(), ''));
        $this->assertEquals(new \stdClass(), $this->serializer->normalize(new \stdClass(), '0'));
        $this->assertEquals(new \stdClass(), $this->serializer->normalize(new \stdClass(), 'fuck'));
        $this->assertEquals(new \stdClass(), $this->serializer->normalize(new \stdClass(), 111));

        $this->assertEquals(new TestClass(), $this->serializer->normalize(new TestClass(), true));
        $this->assertEquals(new TestClass(), $this->serializer->normalize(new TestClass(), false));
        $this->assertEquals(new TestClass(), $this->serializer->normalize(new TestClass(), ''));
        $this->assertEquals(new TestClass(), $this->serializer->normalize(new TestClass(), '0'));
        $this->assertEquals(new TestClass(), $this->serializer->normalize(new TestClass(), 'fuck'));
        $this->assertEquals(new TestClass(), $this->serializer->normalize(new TestClass(), 111));

        $this->assertEquals(new TestClass(), $this->serializer->normalize(null, TestClass::class));
        $this->assertEquals(new TestClass(), $this->serializer->normalize([], TestClass::class));
        $this->assertEquals(new TestClass(), $this->serializer->normalize(1, TestClass::class));
        $this->assertEquals(new TestClass(), $this->serializer->normalize('qwe', TestClass::class));

        $this->assertEquals(new TestClass(), $this->serializer->normalize(null, new TestClass()));
        $this->assertEquals(new TestClass(), $this->serializer->normalize([], new TestClass()));
        $this->assertEquals(new TestClass(), $this->serializer->normalize(1, new TestClass()));
        $this->assertEquals(new TestClass(), $this->serializer->normalize('qwe', new TestClass()));

    }

    public function testSerializeCollection()
    {
        $collection = new TestCollectionClass();

        $object1 = $this->getAnonymousObject();
        $object2 = $this->getAnonymousObject();
        $object3 = $this->getAnonymousObject();

        $object1->setA('a1');
        $object1->getC()->setF('f1');

        $object2->setA('a2');
        $object2->addB('b21');
        $object2->addB('b21');
        $object2->addB('b21');
        $object2->addB('b21');
        $object2->getC()->setF('f2');
        $object2->setIsX(false);

        $object3->setA('a3');
        $object3->addB('b31');
        $object3->addB('b31');
        $object3->addB('b31');
        $object3->addB('b31');
        $object3->getC()->setF('f3');
        $object3->setIsX(true);

        $object1->addB($object2);
        $object2->addB($object3);

        $collection->add($object1);
        $collection->set($object2->getA(), $object2);
        $collection->set($object3->getB(), $object3);
        $json       = $this->serializer->serialize($collection);
        $jsonFilled = $this->serializer->jsonSignificant($collection);
        $this->assertEquals(
            $json,
            '{"0":{"a":"a1","b":[{"a":"a2","b":["b21","b21","b21","b21",{"a":"a3","b":["b31","b31","b31","b31"],"c":{"f":"f3"},"isX":true,"json":null}],"c":{"f":"f2"},"isX":false,"json":null}],"c":{"f":"f1"},"isX":null,"json":null},"a2":{"a":"a2","b":["b21","b21","b21","b21",{"a":"a3","b":["b31","b31","b31","b31"],"c":{"f":"f3"},"isX":true,"json":null}],"c":{"f":"f2"},"isX":false,"json":null},"a3":{"a":"a3","b":["b31","b31","b31","b31"],"c":{"f":"f3"},"isX":true,"json":null}}'
        );
        $this->assertEquals(
            $jsonFilled,
            '{"0":{"a":"a1","b":[{"a":"a2","b":["b21","b21","b21","b21",{"a":"a3","b":["b31","b31","b31","b31"],"c":{"f":"f3"},"isX":true}],"c":{"f":"f2"},"isX":false}],"c":{"f":"f1"}},"a2":{"a":"a2","b":["b21","b21","b21","b21",{"a":"a3","b":["b31","b31","b31","b31"],"c":{"f":"f3"},"isX":true}],"c":{"f":"f2"},"isX":false},"a3":{"a":"a3","b":["b31","b31","b31","b31"],"c":{"f":"f3"},"isX":true}}'
        );
    }

    public function testCollectionToArray()
    {
        $collection = new TestCollectionClass();
        $object1    = $this->getAnonymousObject();
        $object2    = $this->getAnonymousObject();
        $object2->setA('a2');

        $object1->setA('a');
        $object1->addB('b1');
        $object1->addB('b1');
        $object1->addB('b1');
        $object1->addB('b1');
        $object1->setC($object2);
        $object1->setIsX(false);

        $collection->add($object1);
        $collection->add($object2);
        $array       = $this->serializer->normalize($collection);
        $arrayFilled = $this->serializer->normalize($collection, null, Serializer::ONLY_FILLED);
        $this->assertEquals(
            [
                ['a' => 'a', 'b' => ['b1', 'b1', 'b1', 'b1'], 'c' => ['a' => 'a2', 'b' => null, 'isX' => null, 'json' => null, 'c' => ['f' => null]], 'isX' => false, 'json' => null],
                ['a' => 'a2', 'b' => null, 'isX' => null, 'json' => null, 'c' => ['f' => null]],
            ],
            $array
        );
        $this->assertEquals(
            [
                ['a' => 'a', 'b' => ['b1', 'b1', 'b1', 'b1'], 'c' => ['a' => 'a2'], 'isX' => false],
                ['a' => 'a2'],
            ],
            $arrayFilled
        );
    }

    public function testArrayToCollection()
    {
        $fixture = [
            0      => ['a' => 'a1', 'b' => 'qw1', 'isX' => 'fa1', 'c' => ['f' => 111]],
            'qwee' => ['a' => 'a2', 'b' => 'qw2', 'isX' => 'fa2', 'c' => ['f' => 222]],
            '1'    => ['a' => 'a3', 'b' => 'qw3', 'isX' => 'fa3', 'c' => ['f' => 333]],
            ['a' => 'a4', 'b' => 'qw4', 'isX' => 'fa4', 'c' => ['f' => 444]],
        ];
        /**
         * @var TestCollectionClass $collection
         */
        $collection = $this->serializer->normalize($fixture, TestCollectionClass2::class);
        $this->assertEquals(array_keys($collection->getElements()), [0, 'qwee', 1, 2]);
        $this->assertEquals($collection->getElements()[0]->getA(), 'a1');
        $this->assertEquals($collection->getElements()[0]->getB(), 'qw1');
        $this->assertEquals($collection->getElements()[0]->isX(), 'fa1');
        $this->assertEquals($collection->getElements()[0]->getC()->getF(), 111);

        $this->assertEquals($collection->getElements()['qwee']->getA(), 'a2');
        $this->assertEquals($collection->getElements()[1]->getA(), 'a3');
        $this->assertEquals($collection->getElements()[2]->getA(), 'a4');
    }

    public function testCollectionToCollection()
    {
        $collection1 = new TestCollectionClass();
        $collection2 = new TestCollectionClass2();

        $object1 = $this->getAnonymousObject();
        $object1->setA(1);
        $object1->addB('11');
        $object1->addB('11');
        $object1->addB('11');
        $object2 = $this->getAnonymousObject();
        $object2->setA(2);
        $object2->addB('22');
        $object2->addB('22');
        $object2->addB('22');
        $object2->setIsX(true);
        $object3 = $this->getAnonymousObject();
        $object3->setA(3);
        $object3->addB('33');
        $object3->addB('33');
        $object3->addB('33');
        $object3->setIsX(false);
        $object3->getC()->setF(33);


        $collection1->set($object1->getA(), $object1);
        $collection1->set($object2->getA(), $object2);
        $collection1->set($object3->getA(), $object3);
        $collection3 = $this->serializer->normalize($collection1, $collection2);
        $this->assertEquals($collection3->getElements()[1]->getA(), 1);
        $this->assertEquals($collection3->getElements()[2]->getA(), 2);
        $this->assertEquals($collection3->getElements()[3]->getA(), 3);

    }

    public function testBigDataArrayInLittleData()
    {
    }

    public function testBigDataObjectInLittleData()
    {
    }


    public function testJsonToCollection()
    {
        $data = [
            [
                'id'              => "373848436",
                'cartId'          => "680334026",
                'productId'       => "09ccf7ba-7668-11e2-9939-00259036a114",
                'tax'             => "0.0000",
                'price'           => "0.0000",
                'bonusAmount'     => "0",
                'promoMultiplier' => "0",
                'qty'             => "3",
                'weight'          => "15000",
                'prices'          => '{"minimalPrice":1090,"goldPrice":1090,"retailPrice":1090,"date":1548054610}',
                'modified'        => "2019-01-22 14:08:33",
                'code'            => "00000127948",
            ],
            [
                'id'              => "373848446",
                'cartId'          => "680334026",
                'productId'       => "8169676c-95ae-11e5-bed3-00259036a192",
                'tax'             => "0.0000",
                'price'           => "0.0000",
                'bonusAmount'     => "0",
                'promoMultiplier' => "0",
                'qty'             => "1",
                'weight'          => "26160",
                'prices'          => '{"minimalPrice":660.86,"goldPrice":704.06,"retailPrice":727.1,"date":1548055444}',
                'modified'        => "2019-01-21 10:24:04",
                'code'            => "00000151265",
            ],
        ];

        /**
         * @var $products PetCartProductOrmList
         */
        $products = $this->serializer->entityFill($data, PetCartProductOrmList::class);
        $this->assertEquals($products->count(), 2);
        [$element0, $element1] = $products->getElements();
        $this->assertEquals($element0->getId(), '373848436');
        $this->assertEquals($element0->getCartId(), '680334026');
        $this->assertEquals($element0->getProductId(), '09ccf7ba-7668-11e2-9939-00259036a114');
        $this->assertEquals($element0->getTax(), '0.0000');
        $this->assertEquals($element0->getPrice(), '0.0000');
        $this->assertEquals($element0->getBonusAmount(), '0');
        $this->assertEquals($element0->getPromoMultiplier(), '0');
        $this->assertEquals($element0->getQty(), '3');
        $this->assertEquals($element0->getWeight(), '15000');
        $this->assertEquals($element0->getModified(), '2019-01-22 14:08:33');
        $this->assertEquals($element0->getCode(), '00000127948');
        $this->assertTrue($element0->getPrices() instanceof CartItemPrices);
        $this->assertEquals($element0->getPrices()->getDate(), '1548054610');
        $this->assertEquals($element0->getPrices()->getMinimalPrice(), 1090);
        $this->assertEquals($element0->getPrices()->getGoldPrice(), 1090);
        $this->assertEquals($element0->getPrices()->getRetailPrice(), 1090);


        $this->assertEquals($element1->getId(), '373848446');
        $this->assertEquals($element1->getCartId(), '680334026');
        $this->assertEquals($element1->getProductId(), '8169676c-95ae-11e5-bed3-00259036a192');
        $this->assertEquals($element1->getTax(), '0.0000');
        $this->assertEquals($element1->getPrice(), '0.0000');
        $this->assertEquals($element1->getBonusAmount(), '0');
        $this->assertEquals($element1->getPromoMultiplier(), '0');
        $this->assertEquals($element1->getQty(), '1');
        $this->assertEquals($element1->getWeight(), '26160');
        $this->assertEquals($element1->getModified(), '2019-01-21 10:24:04');
        $this->assertEquals($element1->getCode(), '00000151265');
        $this->assertTrue($element1->getPrices() instanceof CartItemPrices);
        $this->assertEquals($element1->getPrices()->getDate(), '1548055444');
        $this->assertEquals($element1->getPrices()->getMinimalPrice(), 660.86);
        $this->assertEquals($element1->getPrices()->getGoldPrice(), 704.06);
        $this->assertEquals($element1->getPrices()->getRetailPrice(), 727.1);

        $products_1 = $this->serializer->normalize($products, null, Serializer::ONLY_FILLED);
        $this->assertEquals($products_1, $data);


        $products_2 = $this->serializer->jsonSignificant($products);

        $json = '[{"id":"373848436","cartId":"680334026","productId":"09ccf7ba-7668-11e2-9939-00259036a114","tax":"0.0000","price":"0.0000","bonusAmount":"0","promoMultiplier":"0","qty":"3","weight":"15000","prices":{"minimalPrice":1090,"goldPrice":1090,"retailPrice":1090,"date":1548054610},"modified":"2019-01-22 14:08:33","code":"00000127948"},{"id":"373848446","cartId":"680334026","productId":"8169676c-95ae-11e5-bed3-00259036a192","tax":"0.0000","price":"0.0000","bonusAmount":"0","promoMultiplier":"0","qty":"1","weight":"26160","prices":{"minimalPrice":660.86,"goldPrice":704.06,"retailPrice":727.1,"date":1548055444},"modified":"2019-01-21 10:24:04","code":"00000151265"}]';
        $this->assertEquals($json, $products_2);


        /**
         * @var $products_3 PetCartProductOrmList
         */
        $products_3 = $this->serializer->entityFill($products_1, PetCartProductOrmList::class);

        [$element0, $element1] = $products_3->getElements();
        $this->assertEquals($element0->getId(), '373848436');
        $this->assertEquals($element0->getCartId(), '680334026');
        $this->assertEquals($element0->getProductId(), '09ccf7ba-7668-11e2-9939-00259036a114');
        $this->assertEquals($element0->getTax(), '0.0000');
        $this->assertEquals($element0->getPrice(), '0.0000');
        $this->assertEquals($element0->getBonusAmount(), '0');
        $this->assertEquals($element0->getPromoMultiplier(), '0');
        $this->assertEquals($element0->getQty(), '3');
        $this->assertEquals($element0->getWeight(), '15000');
        $this->assertEquals($element0->getModified(), '2019-01-22 14:08:33');
        $this->assertEquals($element0->getCode(), '00000127948');
        $this->assertTrue($element0->getPrices() instanceof CartItemPrices);
        $this->assertEquals($element0->getPrices()->getDate(), '1548054610');
        $this->assertEquals($element0->getPrices()->getMinimalPrice(), 1090);
        $this->assertEquals($element0->getPrices()->getGoldPrice(), 1090);
        $this->assertEquals($element0->getPrices()->getRetailPrice(), 1090);


        $this->assertEquals($element1->getId(), '373848446');
        $this->assertEquals($element1->getCartId(), '680334026');
        $this->assertEquals($element1->getProductId(), '8169676c-95ae-11e5-bed3-00259036a192');
        $this->assertEquals($element1->getTax(), '0.0000');
        $this->assertEquals($element1->getPrice(), '0.0000');
        $this->assertEquals($element1->getBonusAmount(), '0');
        $this->assertEquals($element1->getPromoMultiplier(), '0');
        $this->assertEquals($element1->getQty(), '1');
        $this->assertEquals($element1->getWeight(), '26160');
        $this->assertEquals($element1->getModified(), '2019-01-21 10:24:04');
        $this->assertEquals($element1->getCode(), '00000151265');
        $this->assertTrue($element1->getPrices() instanceof CartItemPrices);
        $this->assertEquals($element1->getPrices()->getDate(), '1548055444');
        $this->assertEquals($element1->getPrices()->getMinimalPrice(), 660.86);
        $this->assertEquals($element1->getPrices()->getGoldPrice(), 704.06);
        $this->assertEquals($element1->getPrices()->getRetailPrice(), 727.1);


        /**
         * @var $products_4 PetCartProductOrmList
         */
        $products_4 = $this->serializer->entityFill($products_2, PetCartProductOrmList::class);

        [$element0, $element1] = $products_4->getElements();
        $this->assertEquals($element0->getId(), '373848436');
        $this->assertEquals($element0->getCartId(), '680334026');
        $this->assertEquals($element0->getProductId(), '09ccf7ba-7668-11e2-9939-00259036a114');
        $this->assertEquals($element0->getTax(), '0.0000');
        $this->assertEquals($element0->getPrice(), '0.0000');
        $this->assertEquals($element0->getBonusAmount(), '0');
        $this->assertEquals($element0->getPromoMultiplier(), '0');
        $this->assertEquals($element0->getQty(), '3');
        $this->assertEquals($element0->getWeight(), '15000');
        $this->assertEquals($element0->getModified(), '2019-01-22 14:08:33');
        $this->assertEquals($element0->getCode(), '00000127948');
        $this->assertTrue($element0->getPrices() instanceof CartItemPrices);
        $this->assertEquals($element0->getPrices()->getDate(), '1548054610');
        $this->assertEquals($element0->getPrices()->getMinimalPrice(), 1090);
        $this->assertEquals($element0->getPrices()->getGoldPrice(), 1090);
        $this->assertEquals($element0->getPrices()->getRetailPrice(), 1090);


        $this->assertEquals($element1->getId(), '373848446');
        $this->assertEquals($element1->getCartId(), '680334026');
        $this->assertEquals($element1->getProductId(), '8169676c-95ae-11e5-bed3-00259036a192');
        $this->assertEquals($element1->getTax(), '0.0000');
        $this->assertEquals($element1->getPrice(), '0.0000');
        $this->assertEquals($element1->getBonusAmount(), '0');
        $this->assertEquals($element1->getPromoMultiplier(), '0');
        $this->assertEquals($element1->getQty(), '1');
        $this->assertEquals($element1->getWeight(), '26160');
        $this->assertEquals($element1->getModified(), '2019-01-21 10:24:04');
        $this->assertEquals($element1->getCode(), '00000151265');
        $this->assertTrue($element1->getPrices() instanceof CartItemPrices);
        $this->assertEquals($element1->getPrices()->getDate(), '1548055444');
        $this->assertEquals($element1->getPrices()->getMinimalPrice(), 660.86);
        $this->assertEquals($element1->getPrices()->getGoldPrice(), 704.06);
        $this->assertEquals($element1->getPrices()->getRetailPrice(), 727.1);
    }

    public function testArrayWithJsonInObject()
    {
    }

    public function testArrayToStdClass()
    {
    }

    public function testStdClassToObject()
    {
    }

    public function testStdClassToArray()
    {
    }

    public function testObjectWithJsonToArray()
    {

    }

    public function testSnakeNormalizeArrayToObject()
    {
        $fixture = ['_prop1' => 1, '_prop2_prop' => 2, '_prop3_prop_' => 3, 'prop4' => 4];
        /**
         * @var $obj TestClass3
         */
        $obj = $this->serializer->normalize($fixture, TestClass3::class);
        $this->assertEquals($obj->getProp1(), null);
        $this->assertEquals($obj->getProp2Prop(), null);
        $this->assertEquals($obj->getProp3Prop(), null);
        $this->assertEquals($obj->getProp4(), 4);
        $obj = $this->serializer->normalize($fixture, TestClass3::class, Serializer::CAMEL_FORCE);
        $this->assertEquals($obj->getProp1(), 1);
        $this->assertEquals($obj->getProp2Prop(), 2);
        $this->assertEquals($obj->getProp3Prop(), 3);
        $this->assertEquals($obj->getProp4(), 4);

    }

    public function testSnakeNormalizeObjectToArray()
    {
        $obj = new TestClass3();
        $obj->setProp1(1);
        $obj->setProp2Prop(2);
        $obj->setProp3Prop(3);
        $obj->setProp4(4);
        $array = $this->serializer->normalize($obj);
        $this->assertEquals($array['_prop1'], 1);
        $this->assertEquals($array['_prop2_prop'], 2);
        $this->assertEquals($array['_prop3_prop_'], 3);
        $this->assertEquals($array['prop4'], 4);

        $array = $this->serializer->normalize($obj, null, Serializer::CAMEL_FORCE);
        $this->assertEquals($array['prop1'], 1);
        $this->assertEquals($array['prop2Prop'], 2);
        $this->assertEquals($array['prop3Prop'], 3);
        $this->assertEquals($array['prop4'], 4);
    }


    /**
     * @return TestClass
     */
    private function getAnonymousObject(): TestClass
    {
        return new TestClass();
    }
}

class TestClass implements PropertyAccessInterface, CollectionKeyInterface, HasJsonPropertiesInterface
{
    private $a;
    private $b;
    private $c;
    private $isX;
    private $json;

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
        return ['a', 'b', 'c', 'isX', 'json'];
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
    public function setIsX($isX): void
    {
        $this->isX = $isX;
    }

    /**
     * Метод возвращающий ключ сущности
     * @return string|int
     */
    public function getCollectionKey()
    {
        return $this->a;
    }

    /**
     * @return mixed
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * @param mixed $json
     */
    public function setJson($json): void
    {
        $this->json = $json;
    }

    public function getJsonProperties(): array
    {
        return ['json'];
    }
}

class TestCollectionClass extends AbstractList implements ContainsCollectionInterface
{

    /**
     * Имя класса списка
     * @return string
     */
    public function getClass(): string
    {
        return TestClass::class;
    }

    /**
     * Сохранение элемента списка
     * @param $key
     * @param TestClass $element
     */
    public function set($key, $element): void
    {
        parent::set($element->getA(), $element);
    }

    /**
     * Получение элементов списка
     * @return TestClass[]
     */
    public function getElements(): array
    {
        return $this->elements;
    }
}

class TestCollectionClass2 extends AbstractList implements ContainsCollectionInterface
{

    /**
     * Имя класса списка
     * @return string
     */
    public function getClass(): string
    {
        return TestClass::class;
    }

    /**
     * Получение элементов списка
     * @return TestClass[]
     */
    public function getElements(): array
    {
        return $this->elements;
    }
}

class TestClass3 implements PropertyAccessInterface
{

    private $prop1;
    private $prop2Prop;
    private $prop3Prop;
    private $prop4;

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return [
            '_prop1',
            '_prop2_prop',
            '_prop3_prop_',
            'prop4',
        ];
    }

    /**
     * @return mixed
     */
    public function getProp1()
    {
        return $this->prop1;
    }

    /**
     * @param mixed $prop1
     */
    public function setProp1($prop1): void
    {
        $this->prop1 = $prop1;
    }

    /**
     * @return mixed
     */
    public function getProp2Prop()
    {
        return $this->prop2Prop;
    }

    /**
     * @param mixed $prop2Prop
     */
    public function setProp2Prop($prop2Prop): void
    {
        $this->prop2Prop = $prop2Prop;
    }

    /**
     * @return mixed
     */
    public function getProp3Prop()
    {
        return $this->prop3Prop;
    }

    /**
     * @param mixed $prop3Prop
     */
    public function setProp3Prop($prop3Prop): void
    {
        $this->prop3Prop = $prop3Prop;
    }

    /**
     * @return mixed
     */
    public function getProp4()
    {
        return $this->prop4;
    }

    /**
     * @param mixed $prop4
     */
    public function setProp4($prop4): void
    {
        $this->prop4 = $prop4;
    }


}

class CartItemPrices implements PropertyAccessInterface
{

    protected $minimalPrice;
    protected $goldPrice;
    protected $retailPrice;
    protected $individualPrice;
    protected $date;


    /**
     * @return array
     */
    public function getProperties(): array
    {
        return [
            'minimalPrice',
            'goldPrice',
            'retailPrice',
            'individualPrice',
            'date',
        ];
    }

    /**
     * @return  float|null
     */
    public function getMinimalPrice(): ?float
    {
        return $this->minimalPrice;
    }

    /**
     * @param mixed $minimalPrice
     */
    public function setMinimalPrice($minimalPrice): void
    {
        $this->minimalPrice = (float)$minimalPrice ?: null;
    }

    /**
     * @return float|null
     */
    public function getGoldPrice(): ?float
    {
        return $this->goldPrice;
    }

    /**
     * @param mixed $goldPrice
     */
    public function setGoldPrice($goldPrice): void
    {
        $this->goldPrice = (float)$goldPrice ?: null;
    }

    /**
     * @return  float|null
     */
    public function getRetailPrice(): ?float
    {
        return $this->retailPrice;
    }

    /**
     * @param mixed $retailPrice
     */
    public function setRetailPrice($retailPrice): void
    {
        $this->retailPrice = (float)$retailPrice ?: null;
    }

    /**
     * @return  float|null
     */
    public function getIndividualPrice(): ?float
    {
        return $this->individualPrice;
    }

    /**
     * @param mixed $individualPrice
     */
    public function setIndividualPrice($individualPrice): void
    {
        $this->individualPrice = (float)$individualPrice ?: null;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }
}

class PetCartProductOrmList extends AbstractList implements ContainsCollectionInterface
{

    /**
     * Имя класса списка
     * @return string
     */
    public function getClass(): string
    {
        return PetCartProductOrm::class;
    }

    /**
     * @return PetCartProductOrm[]
     */
    public function getElements(): array
    {
        return parent::getElements();
    }
}

class PetCartProductOrm implements PropertyAccessInterface, HasJsonPropertiesInterface
{
    protected $id;
    protected $cartId;
    protected $productId;
    protected $tax;
    protected $price;
    protected $bonusAmount;
    protected $promoMultiplier;
    protected $qty;
    protected $weight;
    protected $props;
    protected $prices;
    protected $created;
    protected $modified;
    protected $code;

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return [
            'id',
            'cartId',
            'productId',
            'tax',
            'price',
            'bonusAmount',
            'promoMultiplier',
            'qty',
            'weight',
            'props',
            'prices',
            'created',
            'modified',
            'code',
        ];
    }


    public function getJsonProperties(): array
    {
        return [
            'prices',
        ];
    }

    public function __construct()
    {
        $this->prices = new CartItemPrices();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCartId()
    {
        return $this->cartId;
    }

    /**
     * @param mixed $cartId
     */
    public function setCartId($cartId): void
    {
        $this->cartId = $cartId;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param mixed $productId
     */
    public function setProductId($productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return mixed
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param mixed $tax
     */
    public function setTax($tax): void
    {
        $this->tax = $tax;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getBonusAmount()
    {
        return $this->bonusAmount;
    }

    /**
     * @param mixed $bonusAmount
     */
    public function setBonusAmount($bonusAmount): void
    {
        $this->bonusAmount = $bonusAmount;
    }

    /**
     * @return mixed
     */
    public function getPromoMultiplier()
    {
        return $this->promoMultiplier;
    }

    /**
     * @param mixed $promoMultiplier
     */
    public function setPromoMultiplier($promoMultiplier): void
    {
        $this->promoMultiplier = $promoMultiplier;
    }

    /**
     * @return mixed
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * @param mixed $qty
     */
    public function setQty($qty): void
    {
        $this->qty = $qty;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return mixed
     */
    public function getProps()
    {
        return $this->props;
    }

    /**
     * @param mixed $props
     */
    public function setProps($props): void
    {
        $this->props = $props;
    }

    /**
     * @return CartItemPrices
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @param mixed $prices
     */
    public function setPrices($prices): void
    {
        $this->prices = $prices;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created): void
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified): void
    {
        $this->modified = $modified;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }
}