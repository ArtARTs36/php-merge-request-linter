<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigLoader;

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
