<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigLoader;

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
