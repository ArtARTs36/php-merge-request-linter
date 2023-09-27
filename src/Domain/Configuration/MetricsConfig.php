<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

/**
 * @codeCoverageIgnore
 */
readonly class MetricsConfig
{
    public function __construct(
        public MetricsStorageConfig $storage,
    ) {
    }
}
