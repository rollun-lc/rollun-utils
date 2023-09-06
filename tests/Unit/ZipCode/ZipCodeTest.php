<?php

declare(strict_types=1);

namespace rollun\test\Unit\ZipCode;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use rollun\ZipCode\Factory\ZipCodeFactory;

class ZipCodeTest extends TestCase
{
    public function validZipProvider(): array
    {
        return [
            'zip5' => ['55416'],
            'zip5+4' => ['12345-6789'],
            'Zip5 + 4 no second part' => ['12345-', '12345'],
            'Zip5 + 2' => ['12345-12'],
            'ANA-NAN' => ['h2t-1b8'],
            'ANA NAN' => ['h2z 1b8'],
            'ANANAN' => ['H2Z1B8'],
        ];
    }

    /**
     * @dataProvider validZipProvider
     */
    public function testValid(string $validZip, ?string $expected = null)
    {
        $zipCode = ZipCodeFactory::create($validZip);
        $value = $zipCode->getValue();
        self::assertEquals($expected ?? $validZip, $value);
    }

    public function invalidZipProvider(): array
    {
        return [
            'Small zip5' => ['1234'],
            'Large zip5' => ['123456'],
            'Zip5+4 no dash' => ['123456789'],
            'Zip5 + 4 double dash' => ['12345--6789'],
            'Small zip5+4 1' => ['1234-5678'],
            'Small zip5+4 2' => ['12345-678'],
            'Small zip5+4 3' => ['12345-123'],
            'Empty string' => [''],
            'Invalid character in the end' => ['1234L'],
            'Invalid character in the middle' => ['12-45'],
            'Invalid character in the start' => ['I2345'],
            'Leading Z' => ['Z2T 1B8'],
            'Contains O' => ['H2T 1O3'],
            'Invalid format' => ['H2Z A8B']
        ];
    }

    /**
     * @dataProvider invalidZipProvider
     */
    public function testInvalid(string $invalidZip)
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Zip code has invalid format.');
        ZipCodeFactory::create($invalidZip);
    }
}
