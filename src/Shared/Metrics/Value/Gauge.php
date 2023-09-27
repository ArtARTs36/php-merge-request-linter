<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Value;

final class Gauge extends AbstractMetricSample
{
    public function __construct(
        private readonly string|int|float $value,
        protected array $labels = [],
    ) {
    }

    public function getMetricType(): MetricType
    {
        return MetricType::Gauge;
    }

    public function getMetricValue(): string
    {
        return "$this->value";
    }
}
