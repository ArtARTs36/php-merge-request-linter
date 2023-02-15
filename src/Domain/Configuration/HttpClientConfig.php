<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

/**
 * @phpstan-type Params array{base_uri: string, cookies: true, headers: array<string, string>}
 * @codeCoverageIgnore
 */
class HttpClientConfig
{
    public const TYPE_GUZZLE = 'guzzle';
    public const TYPE_DEFAULT = self::TYPE_GUZZLE;
    public const TYPE_NULL = 'null';

    /**
     * @param Params $params
     */
    public function __construct(
        public string $type,
        public array $params,
    ) {
        //
    }
}
