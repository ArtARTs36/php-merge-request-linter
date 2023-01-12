<?php

namespace ArtARTs36\MergeRequestLinter\Support\Http;

use ArtARTs36\MergeRequestLinter\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Contracts\HTTP\Client;
use ArtARTs36\MergeRequestLinter\Contracts\HTTP\HttpClientFactory;
use ArtARTs36\MergeRequestLinter\Contracts\Report\MetricManager;
use ArtARTs36\MergeRequestLinter\Exception\HttpClientTypeNotSupported;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullClient;
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
        if ($config->type === HttpClientConfig::TYPE_GUZZLE || $config->type === HttpClientConfig::TYPE_DEFAULT) {
            $wrapper = new ClientGuzzleWrapper(new GuzzleClient($config->params));

            return new MetricableClient($wrapper, $this->metrics);
        }

        if ($config->type === HttpClientConfig::TYPE_NULL) {
            return new NullClient();
        }

        throw HttpClientTypeNotSupported::make($config->type);
    }
}
