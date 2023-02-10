<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http;

use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\HttpClientTypeNotSupported;

/**
 * Interface for HTTP Client Factory.
 */
interface HttpClientFactory
{
    /**
     * Create HTTP Client.
     * @throws HttpClientTypeNotSupported
     */
    public function create(HttpClientConfig $config): Client;
}
