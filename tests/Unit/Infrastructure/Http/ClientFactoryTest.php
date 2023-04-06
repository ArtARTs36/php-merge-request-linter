<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Http;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\MetricableClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\NullClient;
use ArtARTs36\ContextLogger\NullContextLogger;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\NullMetricManager;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ClientFactoryTest extends TestCase
{
    public function providerForTestCreate(): array
    {
        return [
            [new HttpClientConfig(HttpClientConfig::TYPE_GUZZLE, []), MetricableClient::class],
            [new HttpClientConfig(HttpClientConfig::TYPE_NULL, []), NullClient::class],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientFactory::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientFactory::__construct
     * @param class-string $expectedClass
     * @dataProvider providerForTestCreate
     */
    public function testCreate(HttpClientConfig $config, string $expectedClass): void
    {
        $factory = new ClientFactory(new NullMetricManager(), new NullContextLogger());

        self::assertInstanceOf($expectedClass, $factory->create($config));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientFactory::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientFactory::__construct
     * @dataProvider providerForTestCreate
     */
    public function testCreateOnNotSupported(): void
    {
        self::expectExceptionMessage('HTTP Client with type "non-exists-client-type" not supported');

        $factory = new ClientFactory(new NullMetricManager(), new NullContextLogger());

        $factory->create(new HttpClientConfig('non-exists-client-type', []));
    }
}
