<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Configuration\Resolver\ResolvedConfig;
use ArtARTs36\MergeRequestLinter\Contracts\ConfigResolver;

final class MockConfigResolver implements ConfigResolver
{
    public function __construct(
        private Config $config,
    ) {
        //
    }

    public function resolve(string $directory, ?string $userPath = null): ResolvedConfig
    {
        return new ResolvedConfig($this->config, $directory);
    }
}
