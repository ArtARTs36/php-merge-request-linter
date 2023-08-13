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
use GuzzleHttp\RequestOptions;
use Psr\Http\Client\ClientInterface as PsrClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class ClientGuzzleWrapper implements Client
{
    private const OPTIONS = [
        RequestOptions::HTTP_ERRORS => true,
    ];

    public function __construct(
        private readonly PsrClient&GuzzleClient $http,
        private readonly LoggerInterface $logger,
    ) {
        //
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $response = $this->http->send($request);

        $e = $this->createRequestException($request, $response);

        if ($e !== null) {
            throw $e;
        }

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
            $promises[$key] = $this->http->sendAsync($request, self::OPTIONS);
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
