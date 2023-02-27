<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Time;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Metric;

class Duration implements Metric
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
        return (string) $this;
    }
}
