<?php

namespace ArtARTs36\MergeRequestLinter\Common\Time;

use ArtARTs36\MergeRequestLinter\Domain\Metrics\Metric;

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
        return $this;
    }
}