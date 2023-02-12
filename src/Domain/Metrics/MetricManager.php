<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Metrics;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;

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
     * @return Arrayee<int, Record>
     */
    public function describe(): Arrayee;
}
