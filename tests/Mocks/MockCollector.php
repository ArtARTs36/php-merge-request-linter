<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Collector;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricType;

final class MockCollector implements Collector
{
    private readonly MetricSubject $metricSubject;

    public function __construct(
        ?MetricSubject $metricSubject = null,
        private readonly array $samples = [],
    ) {
        $this->metricSubject = $metricSubject ?? new MetricSubject('mock', 'collector', 'Mock title');
    }

    public function getSubject(): MetricSubject
    {
        return $this->metricSubject;
    }

    public function getMetricType(): MetricType
    {
        // TODO: Implement getMetricType() method.
    }

    public function getSamples(): array
    {
        return $this->samples;
    }
}
