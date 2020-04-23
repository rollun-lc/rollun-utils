<?php


namespace rollun\utils\Cleaner\CleaningValidator;


use Zend\Validator\AbstractValidator;

/**
 * Class FileValidatorTime
 * @package rollun\utils\Cleaner\CleaningValidator
 */
class FileValidatorTime extends AbstractValidator implements CleaningValidatorInterface
{
    /**
     * @var \DateTime|\DateTimeInterface
     */
    public $minTime;

    /**
     * FileValidatorTime constructor.
     * @param $minTime
     * @throws \Exception
     */
    public function __construct($minTime)
    {
        parent::__construct($minTime);

        if (!$minTime instanceof \DateTimeInterface) {
            $minTime = new \DateTime($minTime);
        }

        $this->minTime = $minTime;
    }

    /**
     * @param mixed $value
     * @return bool
     *
     * @todo Decide which function to use: filemtime or filectime?
     */
    public function isValid($value)
    {
        if (!file_exists($value)) {
            return false;
        }

        // TODO
        $mtime = filemtime($value);

        return !($mtime < $this->minTime->getTimestamp());

    }
}