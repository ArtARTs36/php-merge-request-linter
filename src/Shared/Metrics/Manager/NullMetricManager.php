<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Collector;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\CounterVector;

/**
 * @codeCoverageIgnore
 */
class NullMetricManager implements MetricManager
{
    public function getOrRegister(Collector $collector): Collector
    {
        return $collector;
    }

    public function register(Collector $collector): void
    {
        //
    }

    public function describe(): Map
    {
        return new ArrayMap([]);
    }
}
