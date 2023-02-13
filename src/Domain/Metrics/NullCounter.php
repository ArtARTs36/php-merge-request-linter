<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Metrics;

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
        //
    }
}
