<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver;

use ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\User;

class ConfigResolver implements \ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigResolver
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
