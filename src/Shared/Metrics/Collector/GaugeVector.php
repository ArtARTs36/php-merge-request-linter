<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector;

final class GaugeVector extends AbstractVector
{
    /**
     * @param array<string, string> $labels
     */
    public function add(array $labels): Gauge
    {
        return $this->attach(function (array $labels) {
            return new Gauge($this->getSubject(), $labels);
        }, $labels);
    }

    public function getMetricType(): MetricType
    {
        return MetricType::Gauge;
    }
}
