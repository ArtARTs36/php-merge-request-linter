<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage;

/**
 * @codeCoverageIgnore
 */
final class NullStorage implements MetricStorage
{
    public function commit(string $id, array $collectors): void
    {
        // null
    }
}
