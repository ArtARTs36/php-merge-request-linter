<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Prometheus\PushGateway;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client;
use GuzzleHttp\Psr7\Request;

class PushGatewayClient
{
    public function __construct(
        private readonly Client $http,
    ) {
    }

    public function replace(string $job, string $data): void
    {
        $url = "http://host.docker.internal:9091/metrics/job/{$job}";

        $this->http->sendRequest(new Request('POST', $url, body: $data));
    }
}
