<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Value;

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
