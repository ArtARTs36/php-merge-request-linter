<?php

namespace ArtARTs36\MergeRequestLinter\Report\Metrics\Value;

use ArtARTs36\MergeRequestLinter\Contracts\Report\Metric;

final class StringMetric implements Metric
{
    public function __construct(
        private readonly string $value,
    ) {
        //
    }

    public function getMetricValue(): string
    {
        return $this->value;
    }
}
