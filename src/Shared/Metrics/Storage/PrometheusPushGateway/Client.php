<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway;

use Psr\Http\Client\ClientInterface as HttpClient;
use GuzzleHttp\Psr7\Request;

class Client
{
    public function __construct(
        private readonly HttpClient $http,
        private readonly string $address,
    ) {
    }

    public function replace(string $job, string $data): void
    {
        $url = sprintf("%s/metrics/job/%s", $this->address, $job);

        $this->http->sendRequest(new Request('POST', $url, body: $data));
    }
}
