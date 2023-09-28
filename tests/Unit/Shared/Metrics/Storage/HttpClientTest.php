<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Metrics\Storage;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\HttpClient;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockClient;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;
use Psr\Http\Client\ClientInterface;

final class HttpClientTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\HttpClient::replace
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\HttpClient::__construct
     */
    public function testReplace(): void
    {
        $http = new MockClient();

        $client = new HttpClient($http, 'http://push-gateway');

        $client->replace('job-123', 'content');

        self::assertNotNull($http->lastRequest());
        self::assertEquals(
            'http://push-gateway/metrics/job/job-123',
            $http->lastRequest()->getUri()->__toString(),
        );
    }
}
