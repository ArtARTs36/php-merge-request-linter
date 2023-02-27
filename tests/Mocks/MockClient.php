<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class MockClient implements Client
{
    /** @var array<RequestInterface> */
    private array $requests = [];

    public function lastRequest(): ?RequestInterface
    {
        return end($this->requests);
    }

    /**
     * @return array<RequestInterface>
     */
    public function requests(): array
    {
        return $this->requests;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->requests[] = $request;

        return new Response();
    }

    public function sendAsyncRequests(array $requests): array
    {
        foreach ($requests as $request) {
            $this->requests[] = $request;
        }

        return [];
    }
}
