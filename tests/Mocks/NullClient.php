<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class NullClient implements ClientInterface
{
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        //
    }
}
