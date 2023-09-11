<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Value;

/**
 * @codeCoverageIgnore
 */
final class NullCounter implements Counter
{
    public function getMetricValue(): string
    {
        return '';
    }

    public function inc(): void
    {
    }
}
