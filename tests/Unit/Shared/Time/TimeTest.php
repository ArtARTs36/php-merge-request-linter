<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Time;

use ArtARTs36\MergeRequestLinter\Shared\Time\Time;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class TimeTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\Time::fromString
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
                'hour' => $time->hour->value(),
                'minute' => $time->minute->value(),
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
