<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Report;

interface Counter extends Metric
{
    /**
     * Increment metric value.
     */
    public function inc(): void;
}
