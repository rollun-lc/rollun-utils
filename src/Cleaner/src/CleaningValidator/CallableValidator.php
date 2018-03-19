<?php

namespace rollun\utils\Cleaner\CleaningValidator;

use rollun\utils\Cleaner\CleaningValidator\CleaningValidatorInterface;

class CallableValidator implements CleaningValidatorInterface
{

    /**
     * @var callable
     */
    protected $callable;

    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    public function isValid($value): bool
    {
        return call_user_func($this->callable, $value);
    }

}
