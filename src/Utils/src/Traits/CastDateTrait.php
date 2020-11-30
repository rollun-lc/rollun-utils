<?php


namespace rollun\utils\Traits;


trait CastDateTrait
{
    protected function castDate($date)
    {
        if ($date instanceof \DateTimeInterface) {
            return $date;
        }

        if (is_numeric($date)) {
            $date = date('Y-m-d H:i:s', $date);
        }

        $result = new \DateTime($date);

        return $result;
    }
}