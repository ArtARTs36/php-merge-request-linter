<?php

namespace ArtARTs36\MergeRequestLinter\Report\Metrics;

class MetricSubject
{
    public function __construct(
        public readonly string $key,
        public readonly string $name,
    ) {
        //
    }
}
