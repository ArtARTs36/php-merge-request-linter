<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Metrics;

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
