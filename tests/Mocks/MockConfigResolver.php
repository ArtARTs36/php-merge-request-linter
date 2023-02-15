<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver\ResolvedConfig;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\User;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigResolver;

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
