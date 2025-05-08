<?php

namespace Rollun\Test\Unit\Utils\Utils;

use PHPUnit\Framework\TestCase;
use rollun\utils\CallAttemptsTrait;

class CallAttemptsTraitTest extends TestCase
{
    public function testCallAttempts()
    {
        $object = new class {
            use CallAttemptsTrait;

            public function test($data) {}
        };

        $param = 'world';
        $result = $object->callAttempts(function ($param) {
            static $count = 0;
            $count++;
            if ($count < 3) {
                throw new \Exception('Test');
            }
            return 'Hello ' . $param;
        }, $param);

        $this->assertEquals('Hello world', $result);
    }
}
