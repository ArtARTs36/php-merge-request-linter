<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client;

use ArtARTs36\MergeRequestLinter\Domain\Metrics\MetricManager;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\HttpClientFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\HttpClientTypeNotSupported;
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
            if (! class_exists('\GuzzleHttp\Client')) {
                throw new HttpClientTypeNotSupported('Guzzle Client unavailable');
            }

            $wrapper = new ClientGuzzleWrapper(new GuzzleClient($config->params));

            return new MetricableClient($wrapper, $this->metrics);
        }

        if ($config->type === HttpClientConfig::TYPE_NULL) {
            return new NullClient();
        }

        throw HttpClientTypeNotSupported::make($config->type);
    }
}
