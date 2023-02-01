<?php

namespace ArtARTs36\MergeRequestLinter\Configuration;

class ReporterConfig
{
    public function __construct(
        public readonly ?string          $uri,
        public readonly bool             $suppressExceptions,
        public readonly HttpClientConfig $httpClient,
    ) {
        //
    }

    /**
     * @param array<mixed> $array
     */
    public static function fromArray(array $array): self
    {
        return new self(
            $array['uri'] ?? null,
            $array['suppress_exceptions'] ?? false,
            new HttpClientConfig(
                $array['http_client']['type'] ?? HttpClientConfig::TYPE_DEFAULT,
                $array['http_client']['params'] ?? [],
            ),
        );
    }
}
