<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\HttpClientFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\HttpClientTypeNotSupported;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricManager;
use GuzzleHttp\Client as GuzzleClient;

class ClientFactory implements HttpClientFactory
{
    public function __construct(
        private readonly MetricManager $metrics,
    ) {
        //
    }

    public function create(HttpClientConfig $config): Client
    {
        if ($config->type === HttpClientConfig::TYPE_GUZZLE) {
            $wrapper = new ClientGuzzleWrapper(new GuzzleClient($config->params));

            return new MetricableClient($wrapper, $this->metrics);
        }

        if ($config->type === HttpClientConfig::TYPE_NULL) {
            return new NullClient();
        }

        throw HttpClientTypeNotSupported::make($config->type);
    }
}
