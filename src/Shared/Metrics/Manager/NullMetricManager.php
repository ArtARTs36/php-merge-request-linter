<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSample;

/**
 * @codeCoverageIgnore
 */
class NullMetricManager implements MetricManager
{
    public function add(MetricSubject $subject, MetricSample $value): MetricManager
    {
        return $this;
    }

    public function describe(): Arrayee
    {
        return new Arrayee([]);
    }
}
