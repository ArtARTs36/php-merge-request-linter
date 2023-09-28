<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector;

class Sample
{
    /**
     * @param array<string, string> $labels
     */
    public function __construct(
        public readonly string|int|float $value,
        public readonly array $labels,
    ) {
    }
}
