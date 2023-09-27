<?php

namespace ArtARTs36\MergeRequestLinter\Application\Report\Reporter;

use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientGuzzleWrapper;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\MetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\PushGateway;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\Client;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\Renderer;
use GuzzleHttp\Client as HttpClient;
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
                new PushGateway(new Client(new ClientGuzzleWrapper(new HttpClient(), $this->logger)), new Renderer()),
            );
        }
    }
}
