<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Configuration\Loader;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\LinterConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LinterOptions;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders\Proxy;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockConfigLoader;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ConfigLoaderProxyTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders\Proxy::load
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
