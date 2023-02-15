<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver;

use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\User;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigLoader;

class ConfigResolver implements \ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigResolver
{
    public function __construct(
        private PathResolver $path,
        private ConfigLoader $loader,
    ) {
        //
    }

    public function resolve(User $user): ResolvedConfig
    {
        $path = $this->path->resolve($user);

        return new ResolvedConfig($this->loader->load($path), $path);
    }
}
