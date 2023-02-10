<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration;

class HttpClientConfig
{
    public const TYPE_GUZZLE = 'guzzle';
    public const TYPE_DEFAULT = self::TYPE_GUZZLE;
    public const TYPE_NULL = 'null';

    /**
     * @param array<string, mixed> $params
     */
    public function __construct(
        public string $type,
        public array $params = [],
    ) {
        //
    }
}
