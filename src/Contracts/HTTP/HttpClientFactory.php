<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\HTTP;

use ArtARTs36\MergeRequestLinter\Configuration\HttpClientConfig;
use Psr\Http\Client\ClientInterface;

/**
 * Interface for HTTP Client Factory.
 */
interface HttpClientFactory
{
    /**
     * Create HTTP Client.
     */
    public function create(HttpClientConfig $config): ClientInterface;
}
