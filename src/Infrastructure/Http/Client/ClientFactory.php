<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client;

use ArtARTs36\MergeRequestLinter\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Contracts\HTTP\Client;
use ArtARTs36\MergeRequestLinter\Contracts\HTTP\HttpClientFactory;
use ArtARTs36\MergeRequestLinter\Contracts\Report\MetricManager;
use ArtARTs36\MergeRequestLinter\Exception\HttpClientTypeNotSupported;
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
