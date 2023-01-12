<?php

namespace ArtARTs36\MergeRequestLinter\Support\Time;

use ArtARTs36\MergeRequestLinter\Contracts\Report\Metricable;

class Duration implements Metricable
{
    public function __construct(
        public readonly float $seconds,
    ) {
        //
    }

    public function __toString(): string
    {
        return "$this->seconds" . 's';
    }

    public function getMetricValue(): string
    {
        return $this;
    }
}
