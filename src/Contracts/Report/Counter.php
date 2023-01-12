<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Report;

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
