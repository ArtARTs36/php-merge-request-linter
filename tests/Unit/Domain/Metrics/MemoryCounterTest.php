<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Domain\Metrics;

use ArtARTs36\MergeRequestLinter\Domain\Metrics\MemoryCounter;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MemoryCounterTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Metrics\MemoryCounter::create
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Metrics\MemoryCounter::getMetricValue
     */
    public function testCreate(): void
    {
        $counter = MemoryCounter::create([0, 1, 2]);

        self::assertEquals('3', $counter->getMetricValue());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Metrics\MemoryCounter::inc
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Metrics\MemoryCounter::getMetricValue
     */
    public function testInc(): void
    {
        $counter = new MemoryCounter(2);

        $counter->inc();

        self::assertEquals('3', $counter->getMetricValue());
    }
}
