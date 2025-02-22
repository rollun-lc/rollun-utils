<?php

namespace rollun\utils\DateTime;

function is_usa_working_day(\DateTimeImmutable $date): bool
{
    return !is_usa_weekend($date) && !is_usa_holiday($date);
}

function is_usa_weekend(\DateTimeImmutable $dateTime): bool
{
    return in_array($dateTime->format("N"), [6, 7]);
}

function is_usa_holiday(\DateTimeImmutable $date): bool
{
    $holidays = get_usa_holidays_by_year($date->format("Y"));
    foreach ($holidays as $holiday) {
        if ($holiday->format('Y-m-d') === $date->format('Y-m-d')) {
            return true;
        }
    }
    return false;
}

function get_usa_holidays_by_year(string $year): array
{
    $observedDate = static function (\DateTimeImmutable $date): \DateTimeImmutable {
        $dayOfWeek = $date->format('N');

        return match ($dayOfWeek) {
            '6' => $date->modify('- 1 day'), // saturday moves to friday
            '7' => $date->modify('+ 1 day'), // sunday moves monday
            default => $date,
        };
    };

    return [
        "New Year's Day" => $observedDate(new \DateTimeImmutable($year . '-01-01')),
        "MLK Day" => new \DateTimeImmutable('Third Monday of January ' . $year),
        "President's Day" => new \DateTimeImmutable('Third Monday of February ' . $year),
        "Memorial Day" => new \DateTimeImmutable('Last Monday of May ' . $year),
        "Juneteenth National Independence Day" => $observedDate(new \DateTimeImmutable($year . '-06-19')),
        "Independence Day" => $observedDate(new \DateTimeImmutable($year . '-07-04')),
        "Labor Day" => new \DateTimeImmutable('First Monday of September ' . $year),
        "Columbus Day" => new \DateTimeImmutable('Second Monday of October ' . $year),
        "Veterans Day" => $observedDate(new \DateTimeImmutable($year . '-11-11')),
        "Thanksgiving" => new \DateTimeImmutable('Fourth Thursday of November ' . $year),
        "Christmas Day" => $observedDate(new \DateTimeImmutable($year . '-12-25'))
    ];
}