<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Record;

/**
 * Metric Storage.
 */
interface MetricStorage
{
    /**
     * Commit metric records.
     *
     * @param array<Record> $records
     */
    public function commit(string $id, array $records): void;
}
