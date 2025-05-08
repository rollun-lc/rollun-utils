<?php

namespace Rollun\Test\Unit\DateTime;

use PHPUnit\Framework\TestCase;
use rollun\utils\DateTime\WorkingDays;

class WorkingDaysTest extends TestCase
{
    protected function setUp(): void {}
    public function testSkipWeekend()
    {
        // create with Saturday and Sunday is weekend
        $workingDays = new WorkingDays([6, 7]);

        // friday date
        $friday = new \DateTimeImmutable('2025-02-07');

        // add one working day
        $result = $workingDays->addWorkingDays($friday, 1);

        // assert that result is Monday
        $this->assertEquals('2025-02-10', $result->format('Y-m-d'));
    }

    public function testStartInWeekendAddOneDay()
    {
        // create with Saturday and Sunday is weekend
        $workingDays = new WorkingDays([6, 7]);

        // Saturday date
        $friday = new \DateTimeImmutable('2025-02-08');

        // add one working day
        $result = $workingDays->addWorkingDays($friday, 1);

        // assert that result is Monday
        $this->assertEquals('2025-02-10', $result->format('Y-m-d'));
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

    public function validWeekendDaysDataProvider(): array
    {
        return [
            'weekendDays4_5_6' => [
                [4, 5, 6],
            ],
            'weekendDays4_7' => [
                [4, 7],
            ],
        ];
    }

    /**
     * @dataProvider  validWeekendDaysDataProvider
     */
    public function testValidateWeekendDaysCorrect(array $weekendDays): void
    {
        new WorkingDays($weekendDays);
        $this->assertTrue(true);
    }

    public function invalidWeekendDaysDataProvider(): array
    {
        return [
            'weekendDays6_5_6' => [
                [6, 5, 6],
            ],
            'weekendDays4_7' => [
                [4, '7'],
            ],
            'weekendDays4_8' => [
                [4, 8],
            ],
        ];
    }

    /**
     * @dataProvider  invalidWeekendDaysDataProvider
     */
    public function testValidateWeekendDaysIncorrect(array $weekendDays): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new WorkingDays($weekendDays);
    }
}
