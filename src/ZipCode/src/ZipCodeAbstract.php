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
    protected $value;

    public function __construct(string $value)
    {
        if (static::isInvalid($value)) {
            throw new InvalidArgumentException('Zip code has invalid format.');
        }
        $this->value = $value;
    }

    protected static function isInvalid(string $zipCode): bool
    {
        return !static::isValid($zipCode);
    }

    abstract public static function isValid(string $zipCode): bool;

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
