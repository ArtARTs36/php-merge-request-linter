<?php

namespace ArtARTs36\MergeRequestLinter\Report;

use ArtARTs36\MergeRequestLinter\Contracts\Report\Metricable;

final class StringValue implements Metricable
{
    public function __construct(
        private readonly string $value,
    ) {
        //
    }

    public function getMetricValue(): string
    {
        return $this->value;
    }
}
