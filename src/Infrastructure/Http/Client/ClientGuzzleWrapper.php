<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client;
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
        return $this->http->send($request, self::OPTIONS);
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
}
