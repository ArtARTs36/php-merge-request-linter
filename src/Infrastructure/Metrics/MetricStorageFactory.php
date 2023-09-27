<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Metrics;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\MetricsStorageConfig;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\MetricStorage;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\NullStorage;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\Client;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\PushGateway;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\Renderer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client as HttpClient;

class MetricStorageFactory
{
    public function __construct(
        private readonly HttpClient $httpClient,
    ) {
    }

    public function create(MetricsStorageConfig $config): MetricStorage
    {
        if ($config->name === MetricsStorageConfig::NAME_PROMETHEUS_PUSH_GATEWAY) {
            return new PushGateway(
                new Client($this->httpClient, $config->address),
                new Renderer(),
            );
        }

        return new NullStorage();
    }
}
