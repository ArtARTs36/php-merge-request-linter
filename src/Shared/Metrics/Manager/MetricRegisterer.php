<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Collector;

/**
 * Interface for managing metrics (time execution, etc.).
 */
interface MetricRegisterer
{
    /**
     * @template C of Collector
     * @param callable(): C $collectorCreator
     * @return C
     */
    public function getOrRegister(string $key, callable $collectorCreator): Collector;

    /**
     * Register collector.
     */
    public function register(Collector $collector): void;
}
