<?php

namespace rollun\ZipCode\Factory;

use rollun\ZipCode\CanadaZipCode;
use rollun\ZipCode\UsaZipCode;
use rollun\ZipCode\ZipCodeAbstract;
use InvalidArgumentException;

class ZipCodeFactory
{
    public static function create(string $zipCode): ZipCodeAbstract
    {
        $objs = [
            UsaZipCode::class,
            CanadaZipCode::class,
        ];
        $zipCode = ZipCodeAbstract::normalize($zipCode);
        foreach ($objs as $obj) {
            if ($obj::isValid($zipCode)) {
                return new $obj($zipCode);
            }
        }
        throw new InvalidArgumentException('Zip code has invalid format.');
    }
}