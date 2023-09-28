<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Collector;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricType;

final class MockCollector implements Collector
{
    public function getSubject(): MetricSubject
    {
        // TODO: Implement getSubject() method.
    }

    public function getMetricType(): MetricType
    {
        // TODO: Implement getMetricType() method.
    }

    public function getSamples(): array
    {
        // TODO: Implement getSamples() method.
    }
}
