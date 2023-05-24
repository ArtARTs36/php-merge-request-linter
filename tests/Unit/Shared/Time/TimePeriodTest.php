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

    public function providerForTestLte(): array
    {
        return [
            [
                '01:00',
                '01:00',
                true,
            ],
            [
                '01:00',
                '01:01',
                true,
            ],
            [
                '01:00',
                '00:59',
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\Time::lte
     * @dataProvider providerForTestLte
     */
    public function testLte(string $time1Val, string $time2Val, bool $expected): void
    {
        self::assertEquals($expected, Time::fromString($time1Val)->lte(Time::fromString($time2Val)));
    }

    public function providerForTestGte(): array
    {
        return [
            [
                '01:00',
                '01:00',
                true,
            ],
            [
                '01:00',
                '01:01',
                false,
            ],
            [
                '01:00',
                '00:59',
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\Time::lte
     * @dataProvider providerForTestGte
     */
    public function testGte(string $time1Val, string $time2Val, bool $expected): void
    {
        self::assertEquals($expected, Time::fromString($time1Val)->gte(Time::fromString($time2Val)));
    }
}
