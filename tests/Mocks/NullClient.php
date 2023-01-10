<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Contracts\HTTP\Client;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class NullClient implements Client
{
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        //
    }

    public function sendAsyncRequests(array $requests): array
    {
        return [];
    }
}
