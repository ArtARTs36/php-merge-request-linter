<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Domain\Metrics;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\IncCounter;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MemoryCounterTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\IncCounter::create
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\IncCounter::getMetricValue
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\IncCounter::__construct
     */
    public function testCreate(): void
    {
        $counter = IncCounter::create([0, 1, 2]);

        self::assertEquals('3', $counter->getMetricValue());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\IncCounter::inc
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\IncCounter::getMetricValue
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\IncCounter::__construct
     */
    public function testInc(): void
    {
        $counter = new IncCounter(2);

        $counter->inc();

        self::assertEquals('3', $counter->getMetricValue());
    }
}
