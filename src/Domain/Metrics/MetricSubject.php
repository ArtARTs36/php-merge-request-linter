<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Metrics;

class MetricSubject
{
    public function __construct(
        public readonly string $key,
        public readonly string $name,
    ) {
        //
    }
}
