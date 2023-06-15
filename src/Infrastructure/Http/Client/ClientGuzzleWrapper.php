<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\ServerUnexpectedResponseException;
use GuzzleHttp\ClientInterface as GuzzleClient;
use GuzzleHttp\Promise\Utils;
use Psr\Http\Client\ClientInterface as PsrClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Psr\Log\LoggerInterface;

class ClientGuzzleWrapper implements Client
{
    public function __construct(
        private readonly PsrClient&GuzzleClient $http,
        private readonly LoggerInterface $logger,
    ) {
        //
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $response = $this->http->sendRequest($request);

        $this->validateResponse($response, $request->getUri());

        return $response;
    }

    public function sendAsyncRequests(array $requests): array
    {
        $promises = [];
        $logContext = ['async_request_urls' => array_map(fn (RequestInterface $request) => $request->getUri()->__toString(), $requests)];

        $this->logger->info(
            sprintf('Sending %d async requests. Waiting', count($requests)),
            $logContext,
        );

        foreach ($requests as $key => $request) {
            $promises[$key] = $this->http->sendAsync($request);
        }

        $responses = Utils::settle($promises)->wait();

        $this->logger->info(
            sprintf('Responses for %d async requests was given', count($requests)),
            $logContext,
        );

        $preparedResponses = [];

        if (! is_array($responses)) {
            throw new \LogicException(sprintf('Failed send request: %s', var_export($responses, true)));
        }

        /** @var int|string $key */
        foreach ($responses as $key => $response) {
            if (! array_key_exists('value', $response)) {
                throw new \LogicException(sprintf('Failed send request: %s', var_export($response, true)));
            }

            if (! $response['value'] instanceof ResponseInterface) {
                throw new \LogicException(sprintf('Failed send request: %s', var_export($response['value'], true)));
            }

            $this->validateResponse($response['value'], $requests[$key]->getUri());

            $preparedResponses[$key] = $response['value'];
        }

        return $preparedResponses;
    }

    /**
     * @throws InvalidCredentialsException
     * @throws ServerUnexpectedResponseException
     */
    private function validateResponse(ResponseInterface $response, UriInterface $url): void
    {
        $host = $url->getHost();

        if ($response->getStatusCode() === 401 || $response->getStatusCode() === 403) {
            throw InvalidCredentialsException::fromResponse($host, $response->getBody()->getContents());
        } elseif ($response->getStatusCode() !== 200 && $response->getStatusCode() !== 201) {
            throw ServerUnexpectedResponseException::create(
                $host,
                $response->getStatusCode(),
                $response->getBody()->getContents()
            );
        }
    }
}
