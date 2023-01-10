<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\HTTP;

use ArtARTs36\MergeRequestLinter\Configuration\HttpClientConfig;

/**
 * Interface for HTTP Client Factory.
 */
interface HttpClientFactory
{
    /**
     * Create HTTP Client.
     */
    public function create(HttpClientConfig $config): Client;
}
