<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Value;

/**
 * @codeCoverageIgnore
 */
final class NullCounter implements Counter
{
    public function getMetricType(): MetricType
    {
        return MetricType::Counter;
    }

    public function getMetricValue(): string
    {
        return '0';
    }

    public function inc(): void
    {
    }
}
