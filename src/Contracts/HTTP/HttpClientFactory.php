<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\HTTP;

use ArtARTs36\MergeRequestLinter\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Exception\HttpClientTypeNotSupported;

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
