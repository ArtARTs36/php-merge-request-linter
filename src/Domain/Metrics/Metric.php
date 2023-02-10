<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Metrics;

/**
 * Interface for metricable objects.
 */
interface Metric
{
    /**
     * Get metric value in string.
     */
    public function getMetricValue(): string;
}
