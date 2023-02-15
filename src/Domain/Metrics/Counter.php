<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Metrics;

/**
 * Interface for Metric Counter.
 */
interface Counter extends Metric
{
    /**
     * Increment metric value.
     */
    public function inc(): void;
}
