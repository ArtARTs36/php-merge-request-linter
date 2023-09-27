<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Metrics\Value;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSample;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSampleProxy;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MetricProxyTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSampleProxy::getMetricValue
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSampleProxy::retrieve
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSampleProxy::__construct
     */
    public function testGetMetricValue(): void
    {
        $proxy = new MetricSampleProxy(function () {
            return new class () implements MetricSample {
                public function getMetricValue(): string
                {
                    return 'test-value';
                }
            };
        });

        self::assertEquals('test-value', $proxy->getMetricValue());
    }
}
