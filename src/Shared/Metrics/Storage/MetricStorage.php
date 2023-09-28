<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Collector;

/**
 * Metric Storage.
 */
interface MetricStorage
{
    /**
     * Commit metric records to persistent storage.
     *
     * @param array<Collector> $collectors
     */
    public function commit(string $id, array $collectors): void;
}
