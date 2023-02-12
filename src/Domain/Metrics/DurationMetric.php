<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Metrics;

use ArtARTs36\MergeRequestLinter\Shared\Time\Duration;

final class DurationMetric implements Metric
{
    public function __construct(
        private readonly Duration $duration,
    ) {
        //
    }

    public function getMetricValue(): string
    {
        return $this->duration;
    }
}
