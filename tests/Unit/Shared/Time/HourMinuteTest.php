<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Time;

use ArtARTs36\MergeRequestLinter\Shared\Time\HourMinute;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class HourMinuteTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\HourMinute::fromString
     * @dataProvider providerForTestFromString
     */
    public function testFromString(string $string, int $expectedHour, int $expectedMinute): void
    {
        $hourMinute = HourMinute::fromString($string);

        self::assertEquals(
            [
                'hour' => $expectedHour,
                'minute' => $expectedMinute,
            ],
            [
                'hour' => $hourMinute->hour->value(),
                'minute' => $hourMinute->minute->value(),
            ],
        );
    }

    public function providerForTestFromString(): array
    {
        return [
            ['12:34', 12, 34],
            ['00:59', 0, 59],
        ];
    }
}
