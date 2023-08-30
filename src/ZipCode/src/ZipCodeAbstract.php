<?php

declare(strict_types=1);

namespace rollun\ZipCode;

use InvalidArgumentException;
use JsonSerializable;
use rollun\utils\String\StringUtils;

abstract class ZipCodeAbstract implements JsonSerializable
{
    /**
     * @var string
     */
    private string $value;

    public function __construct(string $value)
    {
        $this->value = self::normalize($value);
        if (self::isInvalid($this->value)) {
            throw new InvalidArgumentException('Zip code has invalid format.');
        }
    }

    public static function normalize(string $zip): string
    {
        $zip = StringUtils::trim(StringUtils::normalizeSpaces($zip));
        // '12345-' to '12345'
        if (StringUtils::isEndsWith($zip, '-')) {
            $zip = substr($zip, 0, -1); // remove last char
        }
        return $zip;
    }

    private static function isInvalid(string $zipCode): bool
    {
        return !self::isValid($zipCode);
    }

    public static function isValid(string $zipCode): bool
    {
        return static::isValid($zipCode);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function jsonSerialize(): array
    {
        return [
            'value' => $this->getValue()
        ];
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
