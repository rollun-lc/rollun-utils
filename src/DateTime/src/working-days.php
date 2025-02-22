<?php

namespace rollun\utils\DateTime;

function count_working_days(
    \DateTimeImmutable $startDate,
    \DateTimeImmutable $endDate,
    callable $isWorkingDay
): int
{
    $counter = 0;

    $pointer = $startDate;
    while ($pointer <= $endDate) {
        if ($isWorkingDay($pointer)) {
            $counter++;
        }
        $pointer = add_working_days($pointer, 1, $isWorkingDay);
    }

    return $counter;
}

/**
 * @param callable(\DateTimeImmutable):bool $isWorkingDay
 */
function add_working_days(\DateTimeImmutable $date, int $amount, callable $isWorkingDay): \DateTimeImmutable
{
    if ($amount === 0) {
        return to_working_day($date, $isWorkingDay);
    }

    $addedDays = 0;
    while ($addedDays < $amount) {
        $date = $date->add(new \DateInterval("P1D"));

        if ($isWorkingDay($date)) {
            $addedDays++;
        }
    }

    return $date;
}

/**
 * @param callable(\DateTimeImmutable):bool $isWorkingDay
 */
function to_working_day(\DateTimeImmutable $date, callable $isWorkingDay): \DateTimeImmutable
{
    while (!$isWorkingDay($date)) {
        $date = $date->add(new \DateInterval("P1D"));
    }

    return $date;
}