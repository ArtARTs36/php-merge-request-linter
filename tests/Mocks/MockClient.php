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

    /**
     * @param array<string, ResponseInterface> $responses
     */
    public function __construct(
        private array $responses = [],
    ) {
    }

    /**
     * @param array<string, array<mixed>> $contents
     */
    public static function makeOfResponsesContents(array $contents): self
    {
        $responses = [];

        foreach ($contents as $url => $content) {
            $responses[$url] = new Response(
                200,
                [],
                json_encode($content),
            );
        }

        return new self($responses);
    }

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

        return count($this->responses) > 0 ? array_shift($this->responses) : new Response();
    }

    public function sendAsyncRequests(array $requests): array
    {
        foreach ($requests as $request) {
            $this->requests[] = $request;
        }

        return $this->responses;
    }
}
