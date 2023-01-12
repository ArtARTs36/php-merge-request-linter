<?php

namespace ArtARTs36\MergeRequestLinter\Report\Metrics\Manager;

use ArtARTs36\MergeRequestLinter\Contracts\Report\Metric;
use ArtARTs36\MergeRequestLinter\Contracts\Report\MetricManager;
use ArtARTs36\MergeRequestLinter\Report\Metrics\MetricSubject;

class MemoryMetricManager implements MetricManager
{
    /**A
     * @var array<array{MetricSubject, Metric}>
     */
    private array $metrics = [];

    public function add(MetricSubject $subject, Metric $value): self
    {
        $this->metrics[] = [$subject, $value];

        return $this;
    }

    /**
     * @return array<array{MetricSubject, Metric}>
     */
    public function describe(): array
    {
        return $this->metrics;
    }
}
