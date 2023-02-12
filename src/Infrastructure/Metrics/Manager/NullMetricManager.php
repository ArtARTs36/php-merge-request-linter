<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Metrics\Manager;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\Metric;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\MetricManager;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\MetricSubject;

class NullMetricManager implements MetricManager
{
    public function add(MetricSubject $subject, Metric $value): MetricManager
    {
        return $this;
    }

    public function describe(): Arrayee
    {
        return new Arrayee([]);
    }
}
