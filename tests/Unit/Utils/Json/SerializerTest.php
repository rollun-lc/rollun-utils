<?php

namespace Rollun\Test\Unit\Utils\Json;

use rollun\utils\Json\Exception as JsonException;
use rollun\utils\Json\Serializer as JsonSerializer;

class SerializerTest extends SerializerTestAbstract
{

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed
     */
    protected function setUp(): void
    {
        $this->encoder = function ($value) {
            return call_user_func([JsonSerializer::class, 'jsonSerialize'], $value);
        };
        $this->decoder = function ($value) {
            return call_user_func([JsonSerializer::class, 'jsonUnserialize'], $value);
        };
    }

    //==========================================================================

    /**
     * @dataProvider provider_ScalarType
     */
    public function testSerialize_ScalarType($in, $jsonString, $out = null)
    {
        parent::serialize($in, $jsonString, $out);
    }

    /**
     * @dataProvider provider_StringType
     */
    public function testSerialize_StringType($in, $jsonString, $out = null)
    {
        parent::serialize($in, $jsonString, $out);
    }

    /**
     * @dataProvider provider_ArrayType
     */
    public function testSerialize_ArrayType($in, $jsonString, $out = null)
    {
        parent::serialize($in, $jsonString, $out);
    }

    /**
     * @dataProvider provider_ObjectType
     */
    public function testSerialize_ObjectType($in, $jsonString, $out = null)
    {
        parent::serialize($in, $jsonString, $out);
    }

    /**
     * @dataProvider provider_ClosureType
     */
    public function testSerialize_ClosureType($in, $jsonString, $out = null)
    {
        $this->expectException(JsonException::class);
        parent::serialize($in, $jsonString, $out);
    }

    /**
     * @dataProvider provider_ResourceType
     */
    public function testSerialize_ResourceType($in, $jsonString, $out = null)
    {
        $this->expectException(JsonException::class);
        parent::serialize($in, $jsonString, $out);
    }

}
