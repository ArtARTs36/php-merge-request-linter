<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Http;

use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\MetricableClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\NullClient;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\MemoryRegistry;
use ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use GuzzleHttp\Psr7\Request;

final class MetricableClientTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\MetricableClient::sendRequest
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\MetricableClient::__construct
     */
    public function testSendRequest(): void
    {
        $client = new MetricableClient(new NullClient(), $metrics = new MemoryRegistry(LocalClock::utc()));

        $client->sendRequest(new Request('GET', 'http://site.ru'));

        self::assertCount(1, $metrics->describe());
        self::assertEquals('http_send_request', $metrics->describe()->first()->subject->key);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\MetricableClient::sendAsyncRequests
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\MetricableClient::__construct
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\MetricableClient::getHosts
     */
    public function testSendAsyncRequest(): void
    {
        $client = new MetricableClient(new NullClient(), $metrics = new MemoryRegistry(LocalClock::utc()));

        $client->sendAsyncRequests(['k' => new Request('GET', 'http://site.ru')]);

        self::assertCount(1, $metrics->describe());
        self::assertEquals('http_send_request', $metrics->describe()->first()->subject->key);
    }
}
