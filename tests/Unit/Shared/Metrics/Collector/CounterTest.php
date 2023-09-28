<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Metrics\Collector;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Counter;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Sample;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CounterTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Counter::inc
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Counter::getSamples
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Counter::__construct
     */
    public function testInc(): void
    {
        $counter = new Counter(new MetricSubject('', '', ''));

        $counter->inc();

        self::assertEquals([new Sample(1, [])], $counter->getSamples());
    }
}
