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
}
