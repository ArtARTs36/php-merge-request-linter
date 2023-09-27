<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\MetricRegisterer;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Gauge;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Time\Timer;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class MetricableClient implements Client
{
    public function __construct(
        private readonly Client $client,
        private readonly MetricRegisterer $metrics,
    ) {
        $this->metrics->register(new MetricSubject(
            'http',
            'send_request',
            'Wait of response'
        ));
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $timer = Timer::start();

        $response = $this->client->sendRequest($request);

        $this->metrics->add('http_send_request', new Gauge($timer->finish(), [
            'host' => $request->getUri()->getHost(),
        ]));

        return $response;
    }

    public function sendAsyncRequests(array $requests): array
    {
        $timer = Timer::start();

        $responses = $this->client->sendAsyncRequests($requests);

        $hosts = $this->getHosts($requests)->implode(', ');

        $this->metrics->add('http_send_request', new Gauge($timer->finish()));

        return $responses;
    }

    /**
     * @param array<RequestInterface> $requests
     * @return Arrayee<int, string>
     */
    private function getHosts(array $requests): Arrayee
    {
        $hosts = [];

        foreach ($requests as $request) {
            $hosts[$request->getUri()->getHost()] = $request->getUri()->getHost();
        }

        return new Arrayee(array_values($hosts));
    }
}
