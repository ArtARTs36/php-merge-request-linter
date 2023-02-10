<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client;

use ArtARTs36\MergeRequestLinter\Common\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Common\Time\Timer;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\MetricManager;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\MetricSubject;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class MetricableClient implements Client
{
    public function __construct(
        private readonly Client $client,
        private readonly MetricManager $metrics,
    ) {
        //
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $timer = Timer::start();

        $response = $this->client->sendRequest($request);

        $this->metrics->add(new MetricSubject(
            'http_send_request',
            sprintf('[HTTP] Wait of response from %s', $request->getUri()->getHost()),
        ), $timer->finish());

        return $response;
    }

    public function sendAsyncRequests(array $requests): array
    {
        $timer = Timer::start();

        $responses = $this->client->sendAsyncRequests($requests);

        $hosts = $this->getHosts($requests)->implode(', ');

        $this->metrics->add(new MetricSubject(
            'http_send_request',
            sprintf('[HTTP] Wait of response from %s for %d async requests', $hosts, count($requests)),
        ), $timer->finish());

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
