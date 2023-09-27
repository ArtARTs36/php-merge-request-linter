<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

readonly class MetricsStorageConfig
{
    public const NAME_PROMETHEUS_PUSH_GATEWAY = 'prometheusPushGateway';
    public const NAME_NULL = 'null';

    /**
     * @param self::NAME_* $name
     */
    public function __construct(
        public string $name,
        public string $address,
    ) {
    }
}
