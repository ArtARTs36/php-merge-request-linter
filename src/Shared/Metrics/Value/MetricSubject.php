<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Value;

/**
 * @codeCoverageIgnore
 */
class MetricSubject
{
    public function __construct(
        public readonly string $key,
        public readonly string $name,
    ) {
        //
    }
}
