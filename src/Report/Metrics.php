<?php

namespace ArtARTs36\MergeRequestLinter\Report;

use ArtARTs36\MergeRequestLinter\Contracts\Report\Metricable;

class Metrics
{
    /**A
     * @var array<array{MetricSubject, Metricable}>
     */
    private array $metrics = [];

    public function add(MetricSubject $subject, Metricable $value): self
    {
        $this->metrics[$subject->key] = [$subject, $value];

        return $this;
    }

    /**
     * @return array<array{MetricSubject, Metricable}>
     */
    public function describe(): array
    {
        return $this->metrics;
    }
}
