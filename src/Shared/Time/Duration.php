<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Time;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Metric;

readonly class Duration implements Metric
{
    public function __construct(
        public float $seconds,
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
