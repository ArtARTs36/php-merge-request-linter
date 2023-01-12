<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Report;

use ArtARTs36\MergeRequestLinter\Report\MetricSubject;

/**
 * Interface for managing metrics (time execution, etc.).
 */
interface MetricManager
{
    /**
     * Add new metric.
     */
    public function add(MetricSubject $subject, Metricable $value): self;

    /**
     * Describe metrics.
     * @return array<array{MetricSubject, Metricable}>
     */
    public function describe(): array;
}
