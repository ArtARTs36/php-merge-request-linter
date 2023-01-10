<?php

namespace ArtARTs36\MergeRequestLinter\Support\Http;

use ArtARTs36\MergeRequestLinter\CI\System\InteractsWithResponse;
use GuzzleHttp\Promise\Utils;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Client implements \ArtARTs36\MergeRequestLinter\Contracts\HTTP\Client
{
    use InteractsWithResponse;

    public function __construct(
        private readonly ClientInterface&\GuzzleHttp\ClientInterface $http,
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
}
