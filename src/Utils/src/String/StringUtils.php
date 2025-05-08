<?php

declare(strict_types=1);

namespace rollun\utils\String;

class StringUtils
{
    public static function toLowerCase(string $string): string
    {
        return mb_strtolower($string);
    }

    /**
     * Replace multiple spaces with a single space. Note: this function not trim string.
     * Ex. '  Some   dummy string   ' -> ' Some dummy string '
     */
    public static function normalizeSpaces(string $string): string
    {
        return preg_replace('!\s+!', ' ', $string);
    }

    public static function trim(string $string): string
    {
        return trim($string);
    }

    public static function isStartsWith(string $haystack, string $needle): bool
    {
        return str_starts_with($haystack, $needle);
    }

    public static function isEndsWith(string $haystack, string $needle): bool
    {
        return $needle === '' || ($haystack !== '' && str_ends_with($haystack, $needle));
    }
}
