<?php

namespace ArtARTs36\MergeRequestLinter\Support\Http;

use ArtARTs36\MergeRequestLinter\Contracts\HTTP\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
