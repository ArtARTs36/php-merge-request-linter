<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Value;

/**
 * Interface for metricable objects.
 */
interface MetricSample
{
    /**
     * Get a metric type.
     */
    public function getMetricType(): MetricType;

    /**
     * @return array<string, string>
     */
    public function getMetricLabels(): array;

    /**
     * Get metric value in string.
     */
    public function getMetricValue(): string;
}
