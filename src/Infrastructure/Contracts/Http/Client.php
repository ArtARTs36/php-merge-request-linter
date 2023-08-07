<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Client\RequestExceptionInterface;
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
     * @throws RequestExceptionInterface
     */
    public function sendAsyncRequests(array $requests): array;
}
