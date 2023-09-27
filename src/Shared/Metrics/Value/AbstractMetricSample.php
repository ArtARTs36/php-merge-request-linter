<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Value;

abstract class AbstractMetricSample implements MetricSample
{
    /** @var array<string, string> */
    protected array $labels = [];

    /**
     * @return array<string, string>
     */
    public function getMetricLabels(): array
    {
        return $this->labels;
    }
}
