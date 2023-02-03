<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Report;

use ArtARTs36\MergeRequestLinter\Report\Metrics\MetricSubject;
use ArtARTs36\MergeRequestLinter\Report\Metrics\Record;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Arrayee;

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
