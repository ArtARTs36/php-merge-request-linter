<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Value;

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
