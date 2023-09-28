<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Http;

use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\MetricableClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\NullClient;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\MemoryRegistry;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use GuzzleHttp\Psr7\Request;

final class MetricableClientTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\MetricableClient::sendRequest
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\MetricableClient::make
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\MetricableClient::__construct
     */
    public function testSendRequest(): void
    {
        $client = MetricableClient::make(new NullClient(), $metrics = new MemoryRegistry());

        $client->sendRequest(new Request('GET', 'http://site.ru'));

        self::assertCount(1, $metrics->describe());
        self::assertGreaterThan(0.0, $metrics->describe()->first()->getFirstSampleValue());
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\MetricableClient::sendAsyncRequests
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\MetricableClient::make
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\MetricableClient::__construct
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\MetricableClient::getHosts
     */
    public function testSendAsyncRequest(): void
    {
        $client = MetricableClient::make(new NullClient(), $metrics = new MemoryRegistry());

        $client->sendAsyncRequests(['k' => new Request('GET', 'http://site.ru')]);

        self::assertCount(1, $metrics->describe());
        self::assertGreaterThan(0.0, $metrics->describe()->first()->getFirstSampleValue());
    }
}
