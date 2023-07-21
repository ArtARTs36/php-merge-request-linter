<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Configuration\Loader\Loaders;

use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders\Proxy;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockConfigLoader;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ProxyTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders\Proxy::load
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders\Proxy::retrieve
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders\Proxy::__construct
     */
    public function testFactoryCallsCount(): void
    {
        $calls = 0;

        $proxy = new Proxy(function () use (&$calls) {
            $calls++;

            return new MockConfigLoader($this->makeConfig([]));
        });

        $proxy->load('');
        $proxy->load('');

        self::assertEquals(1, $calls);
    }
}
