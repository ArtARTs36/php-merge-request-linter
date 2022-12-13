<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Configuration\Loader;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\ConfigLoaderProxy;
use ArtARTs36\MergeRequestLinter\Contracts\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Support\Map;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ConfigLoaderProxyTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Configuration\Loader\ConfigLoaderProxy::load
     */
    public function testFactoryCallsCount(): void
    {
        $calls = 0;

        $proxy = new ConfigLoaderProxy(function () use (&$calls) {
            $calls++;

            return new class () implements ConfigLoader {
                public function load(string $path): Config
                {
                    return new Config(new Rules([]), new Map([]), new HttpClientConfig(HttpClientConfig::TYPE_NULL));
                }
            };
        });

        $proxy->load('');
        $proxy->load('');

        self::assertEquals(1, $calls);
    }
}
