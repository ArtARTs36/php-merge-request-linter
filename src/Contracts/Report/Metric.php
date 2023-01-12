<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Report;

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
