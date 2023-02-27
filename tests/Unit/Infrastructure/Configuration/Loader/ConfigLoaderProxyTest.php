<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Configuration\Loader;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\Rules;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationsConfig;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders\Proxy;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
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

            return new class () implements ConfigLoader {
                public function load(string $path): Config
                {
                    return new Config(
                        new Rules([]),
                        new ArrayMap([]),
                        new HttpClientConfig(HttpClientConfig::TYPE_NULL, []),
                        new NotificationsConfig(new ArrayMap([]), new ArrayMap([])),
                    );
                }
            };
        });

        $proxy->load('');
        $proxy->load('');

        self::assertEquals(1, $calls);
    }
}
