<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Metric;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSubject;

/**
 * @codeCoverageIgnore
 */
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
