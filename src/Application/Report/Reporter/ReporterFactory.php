<?php

namespace ArtARTs36\MergeRequestLinter\Application\Report\Reporter;

use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientGuzzleWrapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Prometheus\PushGateway\PushGateway;
use ArtARTs36\MergeRequestLinter\Infrastructure\Prometheus\PushGateway\PushGatewayClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Prometheus\PushGateway\Renderer;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricManager;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class ReporterFactory
{
    public function __construct(
        private readonly MetricManager $metrics,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function create(string $type, array $params): Reporter
    {
        if ($type === 'prometheusPushGateway') {
            return new PrometheusPushGatewayReporter(
                $this->metrics,
                new PushGateway(new PushGatewayClient(new ClientGuzzleWrapper(new Client(), $this->logger)), new Renderer()),
            );
        }
    }
}
