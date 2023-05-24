<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Time;

use ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LocalClockTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock::now
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock::utc
     */
    public function testNow(): void
    {
        $started = new \DateTimeImmutable();

        $clock = LocalClock::utc();

        $result = $clock->now();

        self::assertTrue($started <= $result, sprintf(
            'Failed assert: %s < %s',
            $started->format('Y-m-d H:i:s'),
            $result->format('Y-m-d H:i:s'),
        ));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock::localize
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock::__construct
     */
    public function testLocalize(): void
    {
        $clock = new LocalClock($tz = new \DateTimeZone('Europe/Moscow'));

        $date = $clock->localize(new \DateTimeImmutable('now', new \DateTimeZone('UTC')));

        self::assertEquals($tz, $date->getTimezone());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock::create
     */
    public function testCreate(): void
    {
        $prevTimeZone = date_default_timezone_get();
        date_default_timezone_set('UTC');

        $clock = new LocalClock($tz = new \DateTimeZone('Europe/Moscow'));

        $date = $clock->create('now')->getTimezone();

        date_default_timezone_set($prevTimeZone);

        self::assertEquals($tz, $date);
    }
}
