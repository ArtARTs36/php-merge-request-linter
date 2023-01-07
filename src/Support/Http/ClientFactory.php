<?php

namespace ArtARTs36\MergeRequestLinter\Support\Http;

use ArtARTs36\MergeRequestLinter\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Contracts\HTTP\HttpClientFactory;
use ArtARTs36\MergeRequestLinter\Exception\HttpClientTypeNotSupported;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullClient;
use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;

class ClientFactory implements HttpClientFactory
{
    public function create(HttpClientConfig $config): ClientInterface
    {
        if ($config->type === HttpClientConfig::TYPE_GUZZLE || $config->type === HttpClientConfig::TYPE_DEFAULT) {
            return new Client($config->params);
        }

        if ($config->type === HttpClientConfig::TYPE_NULL) {
            return new NullClient();
        }

        throw HttpClientTypeNotSupported::make($config->type);
    }
}
