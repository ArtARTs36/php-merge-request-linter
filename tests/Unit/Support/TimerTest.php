<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Support;

use ArtARTs36\MergeRequestLinter\Support\Timer;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class TimerTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Support\Timer::start
     * @covers \ArtARTs36\MergeRequestLinter\Support\Timer::__construct
     */
    public function testStart(): void
    {
        $timer = Timer::start();

        self::assertLessThan(microtime(true), $this->getPropertyValue($timer, 'started'));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Support\Timer::finish
     * @covers \ArtARTs36\MergeRequestLinter\Support\Timer::__construct
     */
    public function testFinish(): void
    {
        $timer = Timer::start();

        $timer->finish();

        self::assertGreaterThan($timer->finish(), $this->getPropertyValue($timer, 'started'));
    }
}
