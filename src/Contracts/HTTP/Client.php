<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\HTTP;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface for HTTP Client
 */
interface Client extends ClientInterface
{
    /**
     * Send async requests.
     * @param array<string|int, RequestInterface> $requests
     * @return array<string|int, ResponseInterface>
     */
    public function sendAsyncRequests(array $requests): array;
}
