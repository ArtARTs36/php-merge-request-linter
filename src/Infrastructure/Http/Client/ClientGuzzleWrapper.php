<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\BadRequestException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\ForbiddenException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\HttpRequestException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\NotFoundException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\UnauthorizedException;
use GuzzleHttp\ClientInterface as GuzzleClient;
use GuzzleHttp\Promise\Utils;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface as PsrClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class ClientGuzzleWrapper implements Client
{
    public function __construct(
        private readonly PsrClient&GuzzleClient $http,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->logger->info(sprintf(
            '[HttpClient] Sending request to %s',
            $request->getUri(),
        ));

        try {
            $response = $this->http->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new HttpRequestException($request, message: $e->getMessage(), previous: $e);
        }

        $e = $this->createRequestException($request, $response);

        if ($e !== null) {
            $this->logger->warning(sprintf(
                '[HttpClient] Request to %s was failed with status %d: %s',
                $request->getUri(),
                $response->getStatusCode(),
                $e->getMessage(),
            ));

            throw $e;
        }

        $this->logger->info(sprintf(
            '[HttpClient] Request to %s was successful with status %d',
            $request->getUri(),
            $response->getStatusCode(),
        ));

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
            sprintf('[HttpClient] Responses for %d async requests was given', count($requests)),
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

            $preparedResponses[$key] = $response['value'];
        }

        return $preparedResponses;
    }

    private function createRequestException(RequestInterface $request, ResponseInterface $response): ?HttpRequestException
    {
        return match ($response->getStatusCode()) {
            404 => NotFoundException::create($request, $response),
            403 => ForbiddenException::create($request, $response),
            401 => UnauthorizedException::create($request, $response),
            400 => BadRequestException::create($request, $response),
            200, 201 => null,
            default => HttpRequestException::create($request, $response),
        };
    }
}
