<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Domain\Metrics;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Metric;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricProxy;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MetricProxyTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricProxy::getMetricValue
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricProxy::retrieve
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricProxy::__construct
     */
    public function testGetMetricValue(): void
    {
        $proxy = new MetricProxy(function () {
            return new class () implements Metric {
                public function getMetricValue(): string
                {
                    return 'test-value';
                }
            };
        });

        self::assertEquals('test-value', $proxy->getMetricValue());
    }
}
