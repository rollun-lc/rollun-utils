<?php

/**
 * 5-ти значный zip code (https://en.wikipedia.org/wiki/ZIP_Code).
 */
class Zip5Code implements Stringable
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $zipCode 5-ти значеный zip code (ex 99577). Если передается zip+4 код (ex 99577-0727), то он
     * обрезается до первых пяти символов.
     */
    public function __construct(string $zipCode)
    {
        self::validate($zipCode);
        $this->value = $this->resolveZip5Code($zipCode);
    }

    private static function validate(string $zipCode): void
    {
        if (!\rollun\utils\ZipCode\ZipCode::isValidUsaCode($zipCode)) {
            throw new InvalidArgumentException('Only valid USA zip codes is supported.');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $zipCode
     * @return string
     */
    private function resolveZip5Code(string $zipCode): string
    {
        return mb_substr($zipCode, 0, 5);
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}