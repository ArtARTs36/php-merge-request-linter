<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client as HttpClient;
use GuzzleHttp\Psr7\Request;

class Client
{
    public function __construct(
        private readonly HttpClient $http,
    ) {
    }

    public function replace(string $job, string $data): void
    {
        $url = "http://host.docker.internal:9091/metrics/job/{$job}";

        $this->http->sendRequest(new Request('POST', $url, body: $data));
    }
}
