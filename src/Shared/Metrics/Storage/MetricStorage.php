<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Collector;

/**
 * Metric Storage.
 */
interface MetricStorage
{
    /**
     * Commit metric records.
     *
     * @param array<Collector> $collectors
     */
    public function commit(string $id, array $collectors): void;
}
