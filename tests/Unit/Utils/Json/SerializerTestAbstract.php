<?php

namespace Rollun\Test\Unit\Utils\Json;

use PHPUnit\Framework\TestCase;
use rollun\utils\Json\Exception as JsonException;

abstract class SerializerTestAbstract extends TestCase
{

    /**
     * @var callable
     */
    protected $encoder;

    /**
     * @var callable
     */
    protected $decoder;

    //==========================================================================
    public function provider_ScalarType()
    {
        return [
            [false, 'false'],
            [true, 'true'],
            //
            [-30001, '-30001'],
            [-1, '-1'],
            [0, '0'],
            [1, '1'],
            [30001, '30001'],
            //
            [-30001.00001, '-30001.00001'],
            [0.0, '0', 0], //we get 0 - not 0.0
            [30001.00001, '30001.00001']
        ];
    }

    public function provider_StringType()
    {
        return [
            //
            ['-30001', '"-30001"'],
            ['0', '"0"'],
            ['30001.0001', '"30001.0001"'],
            //
            [
                'String строка !"№;%:?*(ХхЁ',
                //if use json_encode($data);
                '"String \u0441\u0442\u0440\u043e\u043a\u0430 !\"\u2116;%:?*(\u0425\u0445\u0401"'
            //if use json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES | SON_HEX_APOS);
//              '"String \u0441\u0442\u0440\u043e\u043a\u0430 !\u0022\u2116;%:?*(\u0425\u0445\u0401\r\n"' - if Json\Coder
            ]
        ];
    }

    public function provider_ArrayType()
    {
        return [
            //
            [
                [],
                '[]'
            ],
            [
                [1, 'a', ['array']],
                '[1,"a",["array"]]'
            ],
            [
                ['one' => 1, 'a', 'next' => ['array']],
                '{"one":1,"0":"a","next":["array"]}'
            ]
        ];
    }

    public function provider_ObjectType()
    {
        return [
            [
                (object) []  // new \stdClass();
                , '{"#type":"stdClass"}'
            ],
            [
                (object) ['prop' => 1]  //$stdClass = new \stdClass(); $stdClass->prop = 1
                , '{"prop":1,"#type":"stdClass"}'
            ],
            [
                new \Exception('Exception', 1)
                , null
            ],
            [
                new JsonException('JsonException', 1, new \Exception('Exception', 1))
                , null
            ],
        ];
    }

    public function provider_ClosureType()
    {
        return [
            [
                fn($val) => $val
                , ''
            ]
        ];
    }

    public function provider_ResourceType()
    {
        return [
            [
                //imagecreate(1, 1), ''
                fopen('/tmp/test', 'w'), ''
            ]
        ];
    }

    //==========================================================================
    public function serialize($value, $expectedJsonString, $expectedValue = null)
    {
        $expectedValue = !is_null($expectedValue) ? $expectedValue : $value; //usialy $expectedValue === $value
        $callableEncoder = $this->encoder;
        $callableDecoder = $this->decoder;
        $jsonString = $callableEncoder($value);
        $decodedValue = $callableDecoder($jsonString);
        if ($expectedJsonString !== null) {
            $jsonStringCopressed = str_replace(chr(13), '', str_replace(chr(10), '', str_replace(' ', '', $jsonString)));
            $expectedJsonStringCopressed = str_replace(chr(13), '', str_replace(chr(10), '', str_replace(' ', '', $expectedJsonString)));
            $this->assertSame(
                    $expectedJsonStringCopressed, $jsonStringCopressed
            );
        }
        $this->assertEquals(
                $expectedValue, $decodedValue
        );
    }

}
