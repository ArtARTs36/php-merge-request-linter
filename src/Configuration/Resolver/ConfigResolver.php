<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Resolver;

use ArtARTs36\MergeRequestLinter\Contracts\ConfigLoader;

class ConfigResolver implements \ArtARTs36\MergeRequestLinter\Contracts\ConfigResolver
{
    public function __construct(
        private PathResolver $path,
        private ConfigLoader $loader,
    ) {
        //
    }

    public function resolve(string $directory, ?string $userFormat = null): ResolvedConfig
    {
        $path = $this->path->resolve($directory, $userFormat);

        return new ResolvedConfig($this->loader->load($path), $path);
    }
}
