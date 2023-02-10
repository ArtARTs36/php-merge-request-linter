<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Config;

final class MockConfigLoader implements ConfigLoader
{
    public function __construct(private Config $config)
    {
        //
    }

    public function load(string $path): Config
    {
        return $this->config;
    }
}
