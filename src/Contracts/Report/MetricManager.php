<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Report;

use ArtARTs36\MergeRequestLinter\Report\Metrics\MetricSubject;
use ArtARTs36\MergeRequestLinter\Report\Metrics\Record;

/**
 * Interface for managing metrics (time execution, etc.).
 */
interface MetricManager
{
    /**
     * Add new metric.
     * @return $this
     */
    public function add(MetricSubject $subject, Metric $value): self;

    /**
     * Describe metrics.
     * @return array<Record>
     */
    public function describe(): array;
}
