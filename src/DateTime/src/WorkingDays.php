<?php

namespace rollun\utils\DateTime;

use DateInterval;
use DateTimeImmutable;

/**
 * Helps DateTime to work with weekdays
 *
 * @package rollun\utils\DateTime
 */
class WorkingDays
{
    protected $weekendDays;

    /**
     * WorkingDays constructor.
     * @param int[] $weekendDays array of the ordinal numbers of the day of the week in accordance with the
     * ISO-8601 standard: 1 (Monday) to 7 (Sunday)
     */
    public function __construct(array $weekendDays = [6, 7])
    {
        $this->validateWeekendDays($weekendDays);
        $this->weekendDays = $weekendDays;
    }

    /**
     * Validation for input weekendDays
     *
     * @param int[] $weekendDays
     * @throws \InvalidArgumentException
     */
    public function validateWeekendDays(array $weekendDays): void
    {
        if ($weekendDays !== array_unique($weekendDays)) {
            throw new \InvalidArgumentException('Weekend days have duplicated values');
        }
        foreach ($weekendDays as $day) {
            if (!is_int($day) || $day < 1 || $day > 7) {
                throw new \InvalidArgumentException('Weekend days must be integer between 1 and 7');
            }
        }
        if (count($weekendDays) === 7) {
            throw new \InvalidArgumentException("All days of the week cannot be days off");
        }
    }

    /**
     * Added only working days to date.
     */
    public function addWorkingDays(DateTimeImmutable $dateTime, int $days): DateTimeImmutable
    {
        return add_working_days($dateTime, $days, [$this, 'isWorkingDay']);
    }

    /**
     * Move date to working day
     *
     * @throws \Exception
     */
    public function toWorkingDay(DateTimeImmutable $dateTime): DateTimeImmutable
    {
        return to_working_day($dateTime, [$this, 'isWorkingDay']);
    }

    /**
     * @throws \Exception
     */
    public function isWorkingDay(DateTimeImmutable $dateTime): bool
    {
        return !$this->isWeekendDay($dateTime) && !$this->isHoliday($dateTime);
    }

    public function isWeekendDay(DateTimeImmutable $dateTime): bool
    {
        return in_array($dateTime->format("N"), $this->weekendDays);
    }

    /**
     * @throws \Exception
     */
    public function isHoliday(DateTimeImmutable $dateTime): bool
    {
        return is_usa_holiday($dateTime);
    }

    /**
     * @throws \Exception
     */
    protected function getHolidaysByYear(string $year): array
    {
        return get_usa_holidays_by_year($year);
    }
}