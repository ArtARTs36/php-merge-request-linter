<?php

namespace ArtARTs36\MergeRequestLinter\Report\Metrics\Value;

use ArtARTs36\MergeRequestLinter\Contracts\Report\Counter;

class MemoryCounter implements Counter
{
    public function __construct(
        private int $count = 0,
    ) {
        //
    }

    public function inc(): void
    {
        ++$this->count;
    }

    public function getMetricValue(): string
    {
        return "$this->count";
    }
}
