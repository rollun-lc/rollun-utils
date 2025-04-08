<?php

namespace Rollun\Test\Unit\Utils\Php;

use rollun\utils\Json\Exception as JsonException;
use rollun\utils\Php\Serializer as PhpSerializer;

abstract class SerializerTestAbstract extends \PHPUnit\Framework\TestCase
{

    public function provider_ScalarType()
    {
        return [
            [false],
            [true],
            //
            [-30001],
            [-1],
            [0],
            [1],
            [30001],
            //
            [-30001.00001],
            [0.0],
            [30001.00001]
        ];
    }

    public function provider_StringType()
    {
        return [
            //
            ['-30001'],
            ['0'],
            ['30001.0001'],
            //
            [
                'String строка !"№;%:?*(ХхЁ'
            ]
        ];
    }

    public function provider_ArrayType()
    {
        return [
            //
            [
                []
            ],
            [
                [1, 'a', ['array']],
            ],
            [
                ['one' => 1, 'a', 'next' => ['array']],
            ]
        ];
    }

    public function provider_ObjectType()
    {
        return [
            [
                (object) []  // new \stdClass();
            ],
            [
                (object) ['prop' => 1]  //$stdClass = new \stdClass(); $stdClass->prop = 1
            ],
            [
                new \Exception('Exception', 1, null)
            ],
            [
                new JsonException('Exception', 1, new \Exception('subException', 1))
            ],
        ];
    }

    public function provider_ClosureType()
    {
        $obj = new \stdClass();
        return [
            [
                function ($val) use ($obj) {
                    $obj->prop = $val;
                    return $obj;
                }
                , ''
            ]
        ];
    }

    public function provider_ResourceType()
    {
        return [
            [
                //imagecreate(1, 1)
                fopen('/tmp/test', 'w'),
            ]
        ];
    }

    //==========================================================================
    public function serialize($value)
    {
        $this->assertEquals($value, PhpSerializer::phpUnserialize(PhpSerializer::phpSerialize($value)));
    }

}
