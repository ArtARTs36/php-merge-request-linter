<?php

namespace ArtARTs36\MergeRequestLinter\Report\Metrics\Manager;

use ArtARTs36\MergeRequestLinter\Contracts\Report\Metric;
use ArtARTs36\MergeRequestLinter\Contracts\Report\MetricManager;
use ArtARTs36\MergeRequestLinter\Report\Metrics\MetricSubject;
use ArtARTs36\MergeRequestLinter\Report\Metrics\Record;

class MemoryMetricManager implements MetricManager
{
    /**
     * @var array<Record>
     */
    private array $records = [];

    public function add(MetricSubject $subject, Metric $value): self
    {
        $this->records[] = new Record(
            $subject,
            $value,
            new \DateTime(),
        );

        return $this;
    }

    /**
     * @return array<Record>
     */
    public function describe(): array
    {
        return $this->records;
    }
}
