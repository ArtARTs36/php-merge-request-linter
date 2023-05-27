<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Time;

use ArtARTs36\MergeRequestLinter\Shared\Time\Time;
use ArtARTs36\MergeRequestLinter\Shared\Time\TimePeriod;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class TimePeriodTest extends TestCase
{
    public function providerForTestMake(): array
    {
        return [
            [
                '12:34-18:05',
                Time::make(12, 34),
                Time::make(18, 5),
            ],
            [
                '12:34 - 18:05',
                Time::make(12, 34),
                Time::make(18, 5),
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\TimePeriod::make
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\TimePeriod::__construct
     * @dataProvider providerForTestMake
     */
    public function testMake(string $value, Time $expectedFrom, Time $expectedTo): void
    {
        $resultPeriod = TimePeriod::make($value);

        self::assertEquals(
            [
                'from_hour' => $expectedFrom->hour,
                'from_minute' => $expectedFrom->minute,
                'to_hour' => $expectedTo->hour,
                'to_minute' => $expectedTo->minute,
            ],
            [
                'from_hour' => $resultPeriod->from->hour,
                'from_minute' => $resultPeriod->from->minute,
                'to_hour' => $resultPeriod->to->hour,
                'to_minute' => $resultPeriod->to->minute,
            ],
        );
    }

    public function providerForTestInput(): array
    {
        return [
            [
                '09:00-21:00',
                '2022-02-02 23:21',
                false,
            ],
            [
                '09:00-21:00',
                '2022-02-02 09:21',
                true,
            ],
            [
                '09:00-21:00',
                '2022-02-02 08:21',
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\TimePeriod::input
     * @dataProvider providerForTestInput
     */
    public function testInput(string $periodValue, string $dateTime, bool $expected): void
    {
        $period = TimePeriod::make($periodValue);

        self::assertEquals($expected, $period->input(new \DateTimeImmutable($dateTime)));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\TimePeriod::day
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\TimePeriod::__construct
     */
    public function testDay(): void
    {
        $period = TimePeriod::day();

        self::assertEquals(
            [0, 0, 23, 59],
            [
                $period->from->hour,
                $period->from->minute,
                $period->to->hour,
                $period->to->minute,
            ],
        );
    }
}
