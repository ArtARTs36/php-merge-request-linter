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
