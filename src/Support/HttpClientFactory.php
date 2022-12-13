<?php

namespace ArtARTs36\MergeRequestLinter\Support;

use ArtARTs36\MergeRequestLinter\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Exception\HttpClientTypeNotSupported;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullClient;
use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;

class HttpClientFactory implements \ArtARTs36\MergeRequestLinter\Contracts\HttpClientFactory
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
