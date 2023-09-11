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
        $this->weekendDays = $weekendDays;
    }

    /**
     * Added only working days to date.
     *
     * @param DateTimeImmutable $dateTime
     * @param int $days
     * @return DateTimeImmutable
     */
    public function addWorkingDays(DateTimeImmutable $dateTime, int $days): DateTimeImmutable
    {
        if ($days === 0) {
            return $this->toWorkingDay($dateTime);
        }

        $addedDays = 0;
        while ($addedDays < $days) {
            $dateTime = $this->addDay($dateTime);
            if ($this->isWorkingDay($dateTime)) {
                $addedDays++;
            }
        }

        return $dateTime;
    }

    /**
     * Move date to working day
     *
     * @param DateTimeImmutable $dateTime
     * @return DateTimeImmutable
     */
    public function toWorkingDay(DateTimeImmutable $dateTime): DateTimeImmutable
    {
        while (!$this->isWorkingDay($dateTime)) {
            $dateTime = $this->addDay($dateTime);
        }

        return $dateTime;
    }

    /**
     * Add 1 day to date
     *
     * @param DateTimeImmutable $dateTime
     * @return DateTimeImmutable
     */
    protected function addDay(DateTimeImmutable $dateTime): DateTimeImmutable
    {
        return $dateTime->add(new DateInterval("P1D"));
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
        $year = $dateTime->format("Y");
        $holidays = $this->getHolidaysByYear($year);
        foreach ($holidays as $holiday) {
            if ($holiday->format('Y-m-d') === $dateTime->format('Y-m-d')) {
                return true;
            }
        }
        return false;
    }

    /**
     * @throws \Exception
     */
    protected function getHolidaysByYear(string $year): array
    {
        return [
            "New Year's Day" => $this->getObservedDate(new DateTimeImmutable($year . '-01-01')),
            "MLK Day" => new DateTimeImmutable('Third Monday of January ' . $year),
            "President's Day" => new DateTimeImmutable('Third Monday of February ' . $year),
            "Memorial Day" => new DateTimeImmutable('Last Monday of May ' . $year),
            "Independence Day" => $this->getObservedDate(new DateTimeImmutable($year . '-07-04')),
            "Labor Day" => new DateTimeImmutable('First Monday of September ' . $year),
            "Columbus Day" => new DateTimeImmutable('Second Monday of October ' . $year),
            "Veterans Day" => $this->getObservedDate(new DateTimeImmutable($year . '-11-11')),
            "Thanksgiving" => new DateTimeImmutable('Fourth Thursday of November ' . $year),
            "Christmas Day" => $this->getObservedDate(new DateTimeImmutable($year . '-12-25'))
        ];
    }

    private function getObservedDate(DateTimeImmutable $holidayDate): DateTimeImmutable
    {
        $dayOfWeek = $holidayDate->format('N');

        if ($dayOfWeek == 6) {
            $holidayDate = $holidayDate->modify('- 1 day'); //saturday moves to friday
        } else if ($dayOfWeek == 7) {
            $holidayDate = $holidayDate->modify('+ 1 day');;  //sunday moves monday
        }

        return $holidayDate;
    }

    /**
     * @throws \Exception
     */
    public function isWorkingDay(DateTimeImmutable $dateTime): bool
    {
        return !$this->isWeekendDay($dateTime) && !$this->isHoliday($dateTime);
    }
}