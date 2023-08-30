<?php

namespace rollun\ZipCode\Factory;

use rollun\ZipCode\CanadaZipCode;
use rollun\ZipCode\UsaZipCode;
use rollun\ZipCode\ZipCodeAbstract;

class ZipCodeFactory
{
    public static function create(string $zipCode)
    {
        $objs = [
            UsaZipCode::class,
            CanadaZipCode::class,
        ];

        foreach ($objs as $obj) {
            if ($obj::isValid($zipCode)) {
                return new $obj($zipCode);
            }
        }
    }
}