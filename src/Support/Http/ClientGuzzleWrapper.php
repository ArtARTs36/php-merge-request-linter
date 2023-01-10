<?php

namespace ArtARTs36\MergeRequestLinter\Support\Http;

use ArtARTs36\MergeRequestLinter\Contracts\HTTP\Client;
use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Exception\ServerUnexpectedResponseException;
use GuzzleHttp\ClientInterface as GuzzleClient;
use GuzzleHttp\Promise\Utils;
use Psr\Http\Client\ClientInterface as PsrClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ClientGuzzleWrapper implements Client
{
    public function __construct(
        private readonly PsrClient&GuzzleClient $http,
    ) {
        //
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $response = $this->http->sendRequest($request);

        $this->validateResponse($response, $request->getUri());

        return $response;
    }

    /**
     * @param array<string, RequestInterface> $requests
     * @return array<string, ResponseInterface>
     */
    public function sendAsyncRequests(array $requests): array
    {
        $promises = [];

        foreach ($requests as $key => $request) {
            $promises[$key] = $this->http->sendAsync($request);
        }

        $responses = Utils::settle($promises)->wait();
        $preparedResponses = [];

        /**
         * @var string $key
         */
        foreach ($responses as $key => $response) {
            if (! $response['value'] instanceof ResponseInterface) {
                throw new \LogicException(sprintf('Failed send request: %s', var_export($response['value'], true)));
            }

            $this->validateResponse($response['value'], $requests[$key]->getUri());

            $preparedResponses[$key] = $response['value'];
        }

        return $preparedResponses;
    }

    private function validateResponse(ResponseInterface $response, string $url): void
    {
        $host = URI::host($url);

        if ($response->getStatusCode() === 401 || $response->getStatusCode() === 403) {
            throw InvalidCredentialsException::fromResponse($host, $response->getBody()->getContents());
        } elseif ($response->getStatusCode() !== 200) {
            throw ServerUnexpectedResponseException::create(
                $host,
                $response->getStatusCode(),
                $response->getBody()->getContents()
            );
        }
    }
}
