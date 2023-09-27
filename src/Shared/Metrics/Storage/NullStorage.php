<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage;

final class NullStorage implements MetricStorage
{
    public function commit(string $id, array $records): void
    {
        // null
    }
}
