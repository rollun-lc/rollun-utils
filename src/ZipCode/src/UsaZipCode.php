<?php

namespace rollun\ZipCode;

use rollun\utils\String\StringUtils;

final class UsaZipCode extends ZipCodeAbstract
{
    public static function isValid(string $zipCode): bool
    {
        /**
         * All valid formats:
         * 12345-1234
         * 12345-12
         * 12345-
         * 12345
         */
        return (bool)preg_match('/^[0-9]{5}(-([0-9]{2}|[0-9]{4}))?$/', $zipCode);
    }

    public static function normalize(string $zip): string
    {
        $zip = parent::normalize($zip);
        // '12345-' to '12345'
        if (StringUtils::isEndsWith($zip, '-')) {
            $zip = substr($zip, 0, -1); // remove last char
        }
        return $zip;
    }

    public function getZip5Code(): string
    {
        return mb_substr($this->getValue(), 0, 5);
    }
}