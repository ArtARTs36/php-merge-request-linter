<?php

namespace ArtARTs36\MergeRequestLinter\Report\Metrics\Manager;

use ArtARTs36\MergeRequestLinter\Contracts\Report\Metric;
use ArtARTs36\MergeRequestLinter\Contracts\Report\MetricManager;
use ArtARTs36\MergeRequestLinter\Report\Metrics\MetricSubject;

class NullMetricManager implements MetricManager
{
    public function add(MetricSubject $subject, Metric $value): MetricManager
    {
        return $this;
    }

    public function describe(): array
    {
        return [];
    }
}
