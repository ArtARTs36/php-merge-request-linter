<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

readonly class MetricsStorageConfig
{
    public function __construct(
        public string $name,
        public string $address,
    ) {
    }
}
