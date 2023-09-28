<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\GaugeVector;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\MetricRegisterer;
use ArtARTs36\MergeRequestLinter\Shared\Time\Timer;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class MetricableClient implements Client
{
    public function __construct(
        private readonly Client      $client,
        private readonly GaugeVector $observer,
    ) {
    }

    public static function make(Client $client, MetricRegisterer $metrics): self
    {
        $observer = $metrics->getOrRegister('http_send_request', static function () {
            return new GaugeVector(new MetricSubject(
                'http',
                'send_request',
                'Wait of response'
            ));
        });

        return new self($client, $observer);
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $timer = Timer::start();

        $response = $this->client->sendRequest($request);

        $this
            ->observer
            ->add([
                'host' => $request->getUri()->getHost(),
            ])
            ->set($timer->finish()->seconds);

        return $response;
    }

    public function sendAsyncRequests(array $requests): array
    {
        $timer = Timer::start();

        $responses = $this->client->sendAsyncRequests($requests);

        $hosts = $this->getHosts($requests)->implode(',');

        $this
            ->observer
            ->add([
                'host' => $hosts,
            ])
            ->set($timer->finish()->seconds);

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
