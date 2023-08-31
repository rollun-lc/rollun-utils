<?php

namespace rollun\ZipCode;

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

    public function getZip5Code(): string
    {
        return mb_substr($this->getValue(), 0, 5);
    }

    protected static function isInvalid(string $zipCode): bool
    {
        return !self::isValid($zipCode);
    }
}