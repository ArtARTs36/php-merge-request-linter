<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver\ResolvedConfig;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\User;

final class MockConfigResolver implements ConfigResolver
{
    public function __construct(
        private Config $config,
    ) {
        //
    }

    public function resolve(User $user): ResolvedConfig
    {
        return new ResolvedConfig($this->config, $user->workDirectory);
    }
}
