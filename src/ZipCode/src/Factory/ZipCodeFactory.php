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
        foreach ($objs as $obj) {
            $normalizedZipCode = $obj::normalize($zipCode);
            if ($obj::isValid($normalizedZipCode)) {
                return new $obj($normalizedZipCode);
            }
        }
        throw new InvalidArgumentException('Zip code has invalid format.');
    }
}