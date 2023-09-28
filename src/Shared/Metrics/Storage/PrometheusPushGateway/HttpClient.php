<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway;

use Psr\Http\Client\ClientInterface as Http;
use GuzzleHttp\Psr7\Request;

final class HttpClient implements Client
{
    public function __construct(
        private readonly Http $http,
        private readonly string $address,
    ) {
    }

    public function replace(string $job, string $data): void
    {
        $url = sprintf("%s/metrics/job/%s", $this->address, $job);

        $this->http->sendRequest(new Request('POST', $url, body: $data));
    }
}
