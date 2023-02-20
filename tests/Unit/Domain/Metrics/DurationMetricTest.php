<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Domain\Metrics;

use ArtARTs36\MergeRequestLinter\Domain\Metrics\DurationMetric;
use ArtARTs36\MergeRequestLinter\Shared\Time\Duration;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class DurationMetricTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Metrics\DurationMetric::getMetricValue
     * @covers \ArtARTs36\MergeRequestLinter\Domain\Metrics\DurationMetric::__construct
     */
    public function testGetMetricValue(): void
    {
        $metric = new DurationMetric(new Duration(5));

        self::assertEquals('5s', $metric->getMetricValue());
    }
}
