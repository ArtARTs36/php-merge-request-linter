<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Configuration\Loader;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Configuration\Loader\Loaders\Proxy;
use ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ConfigLoaderProxyTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Configuration\Loader\Loaders\Proxy::load
     */
    public function testFactoryCallsCount(): void
    {
        $calls = 0;

        $proxy = new Proxy(function () use (&$calls) {
            $calls++;

            return new class () implements ConfigLoader {
                public function load(string $path): Config
                {
                    return new Config(new Rules([]), new ArrayMap([]), new HttpClientConfig(HttpClientConfig::TYPE_NULL));
                }
            };
        });

        $proxy->load('');
        $proxy->load('');

        self::assertEquals(1, $calls);
    }
}
