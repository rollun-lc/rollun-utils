<?php

namespace rollun\ZipCode;

use rollun\utils\String\StringUtils;

final class CanadaZipCode extends ZipCodeAbstract
{
    public static function isValid(string $zipCode): bool
    {
        /**
         * Allows:
         * h2t-1b8
         * h2z 1b8
         * H2Z1B8
         */
        return (bool)preg_match('/^[ABCEGHJ-NPRSTVXY]\d[ABCEGHJ-NPRSTV-Z][ -]?\d[ABCEGHJ-NPRSTV-Z]\d$/i', $zipCode);
    }

    public static function normalize(string $zip): string
    {
        $zip = parent::normalize($zip);
        return StringUtils::trim(StringUtils::normalizeSpaces($zip));
    }
}