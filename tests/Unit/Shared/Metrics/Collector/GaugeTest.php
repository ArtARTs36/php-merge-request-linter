<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Metrics\Collector;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Gauge;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricSubject;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class GaugeTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Gauge::set
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Gauge::getSamples
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Gauge::__construct
     */
    public function testSet(): void
    {
        $gauge = new Gauge(new MetricSubject('', '', ''));

        self::assertEquals(0, $gauge->getFirstSampleValue());

        $gauge->set(1);

        self::assertEquals(1, $gauge->getFirstSampleValue());
    }
}
