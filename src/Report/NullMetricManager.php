<?php

namespace ArtARTs36\MergeRequestLinter\Report;

use ArtARTs36\MergeRequestLinter\Contracts\Report\Metricable;
use ArtARTs36\MergeRequestLinter\Contracts\Report\MetricManager;

class NullMetricManager implements MetricManager
{
    public function add(MetricSubject $subject, Metricable $value): MetricManager
    {
        return $this;
    }

    public function describe(): array
    {
        return [];
    }
}
