<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Time;

use ArtARTs36\MergeRequestLinter\Shared\Time\Timer;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class TimerTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\Timer::start
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\Timer::__construct
     */
    public function testStart(): void
    {
        $timer = Timer::start();

        self::assertLessThanOrEqual(microtime(true), $this->getPropertyValue($timer, 'started'));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\Timer::finish
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Time\Timer::__construct
     */
    public function testFinish(): void
    {
        $timer = Timer::start();

        self::assertGreaterThan($timer->finish()->seconds, $this->getPropertyValue($timer, 'started'));
    }
}
