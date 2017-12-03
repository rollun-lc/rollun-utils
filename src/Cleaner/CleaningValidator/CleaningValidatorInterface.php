<?php

namespace rollun\utils\Cleaner\CleaningValidator;

interface CleaningValidatorInterface
{

    /**
     * 
     * @param  mixed $value
     * @return bool
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($value);
}
