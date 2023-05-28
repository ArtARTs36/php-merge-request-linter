<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Time;

use ArtARTs36\MergeRequestLinter\Shared\Time\Time;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class TimeTest extends TestCase
{
    public function providerForTestFromString(): array
    {
        return [
            ['12:34', 12, 34],
            ['00:59', 0, 59],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\Time::fromString
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\Time::__construct
     * @dataProvider providerForTestFromString
     */
    public function testFromString(string $string, int $expectedHour, int $expectedMinute): void
    {
        $time = Time::fromString($string);

        self::assertEquals(
            [
                'hour' => $expectedHour,
                'minute' => $expectedMinute,
            ],
            [
                'hour' => $time->hour,
                'minute' => $time->minute,
            ],
        );
    }

    public function providerForTestFromStringOnException(): array
    {
        return [
            [
                'time' => '01:01:01',
                'exception' => 'Value must be follows mask "hh:mm"',
            ],
            [
                'time' => 'k1:01',
                'exception' => 'Value must be follows mask "hh:mm"',
            ],
            [
                'time' => '01:k1',
                'exception' => 'Value must be follows mask "hh:mm"',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\Time::fromString
     * @dataProvider providerForTestFromStringOnException
     */
    public function testFromStringOnException(string $timeString, string $exception): void
    {
        self::expectExceptionMessage($exception);

        Time::fromString($timeString);
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
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\Time::gte
     * @dataProvider providerForTestGte
     */
    public function testGte(string $time1Val, string $time2Val, bool $expected): void
    {
        self::assertEquals($expected, Time::fromString($time1Val)->gte(Time::fromString($time2Val)));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\Time::fromDateTime
     */
    public function testFromDateTime(): void
    {
        $time = Time::fromDateTime(new \DateTime('2022-02-02 01:59'));

        self::assertEquals(
            [
                'hour' => 01,
                'minute' => 59,
            ],
            [
                'hour' => $time->hour,
                'minute' => $time->minute,
            ],
        );
    }

    public function providerForTestMakeOnInvalidTimeValue(): array
    {
        return [
            [
                -1,
                0,
                'Hour must be >= 0 and <= 23. Given: -1',
            ],
            [
                24,
                0,
                'Hour must be >= 0 and <= 23. Given: 24',
            ],
            [
                2,
                -1,
                'Minute must be >= 0 and <= 59. Given: -1',
            ],
            [
                2,
                60,
                'Minute must be >= 0 and <= 59. Given: 60',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\Time::make
     * @dataProvider providerForTestMakeOnInvalidTimeValue
     */
    public function testMakeOnInvalidTimeValue(int $hour, int $minute, string $expectedException): void
    {
        self::expectExceptionMessage($expectedException);

        Time::make($hour, $minute);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\Time::min
     */
    public function testMin(): void
    {
        $time = Time::min();

        self::assertEquals(
            [
                'hour' => 0,
                'minute' => 0,
            ],
            [
                'hour' => $time->hour,
                'minute' => $time->minute,
            ],
        );
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\Time::max
     */
    public function testMax(): void
    {
        $time = Time::max();

        self::assertEquals(
            [
                'hour' => 23,
                'minute' => 59,
            ],
            [
                'hour' => $time->hour,
                'minute' => $time->minute,
            ],
        );
    }
}
