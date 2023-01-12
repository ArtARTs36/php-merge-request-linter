<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Report;

use ArtARTs36\MergeRequestLinter\Report\Metrics\MetricSubject;

/**
 * Interface for managing metrics (time execution, etc.).
 */
interface MetricManager
{
    /**
     * Add new metric.
     */
    public function add(MetricSubject $subject, Metric $value): self;

    /**
     * Describe metrics.
     * @return array<array{MetricSubject, Metric}>
     */
    public function describe(): array;
}
