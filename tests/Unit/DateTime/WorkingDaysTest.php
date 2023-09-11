<?php

namespace Unit\DateTime;

use PHPUnit\Framework\TestCase;
use rollun\utils\DateTime\WorkingDays;

class WorkingDaysTest extends TestCase
{
    protected function setUp(): void
    {
    }
    public function testSkipWeekend()
    {
        // create with Saturday and Sunday is weekend
        $workingDays = new WorkingDays([6, 7]);

        // friday date
        $friday = new \DateTimeImmutable('friday');

        // add one working day
        $result = $workingDays->addWorkingDays($friday, 1);

        // assert that result is Monday
        $this->assertEquals(1, $result->format('N'));
    }

    public function testStartInWeekendAddOneDay()
    {
        // create with Saturday and Sunday is weekend
        $workingDays = new WorkingDays([6, 7]);

        // Saturday date
        $friday = new \DateTimeImmutable('saturday');

        // add one working day
        $result = $workingDays->addWorkingDays($friday, 1);

        // assert that result is Monday
        $this->assertEquals(1, $result->format('N'));
    }

    public function testSkipHolidays()
    {
        // create with December 25 is holiday
        $workingDays = new WorkingDays([]);

        $date = new \DateTimeImmutable('December 24');

        // add one working day
        $result = $workingDays->addWorkingDays($date, 1);

        // assert that result is December 26
        $this->assertEquals('12-26', $result->format('m-d'));
    }

    public function testSkipHolidaysAndWeekend()
    {
        $workingDays = new WorkingDays([6, 7]);

        $friday = new \DateTimeImmutable('19-02-2024');

        $result = $workingDays->addWorkingDays($friday, 1);

        // assert that result is Tuesday
        $this->assertEquals(2, $result->format('N'));
    }
}