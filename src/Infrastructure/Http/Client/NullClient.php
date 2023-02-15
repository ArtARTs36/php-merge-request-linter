<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Null object for Client Interface.
 * @codeCoverageIgnore
 */
final class NullClient implements Client
{
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return new Response();
    }

    public function sendAsyncRequests(array $requests): array
    {
        return [];
    }
}
