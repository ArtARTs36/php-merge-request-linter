<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Configuration\Resolver\ResolvedConfig;
use ArtARTs36\MergeRequestLinter\Configuration\User;
use ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigResolver;

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
