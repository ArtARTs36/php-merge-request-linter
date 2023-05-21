<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Time;

use ArtARTs36\MergeRequestLinter\Shared\Time\Clock;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ClockTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\Clock::now
     */
    public function testNow(): void
    {
        $started = new \DateTimeImmutable();

        $clock = new Clock();

        $result = $clock->now();

        self::assertTrue($started <= $result, sprintf(
            'Failed assert: %s < %s',
            $started->format('Y-m-d H:i:s'),
            $result->format('Y-m-d H:i:s'),
        ));
    }
}
