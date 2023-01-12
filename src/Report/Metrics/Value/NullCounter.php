<?php

namespace ArtARTs36\MergeRequestLinter\Report\Metrics\Value;

final class NullCounter implements \ArtARTs36\MergeRequestLinter\Contracts\Report\Counter
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
