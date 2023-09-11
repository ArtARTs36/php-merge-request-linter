<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Value;

/**
 * @codeCoverageIgnore
 */
readonly class MetricSubject
{
    public function __construct(
        public string $key,
        public string $name,
    ) {
    }
}
