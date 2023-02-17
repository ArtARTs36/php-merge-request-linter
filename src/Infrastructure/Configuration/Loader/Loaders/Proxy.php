<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigLoader;

final class Proxy implements ConfigLoader
{
    private ?ConfigLoader $loader = null;

    /**
     * @param \Closure(): ConfigLoader $factory
     */
    public function __construct(
        private \Closure $factory,
    ) {
        //
    }

    public function load(string $path): Config
    {
        return $this->retrieve()->load($path);
    }

    private function retrieve(): ConfigLoader
    {
        if ($this->loader === null) {
            $factory = $this->factory;

            $this->loader = $factory();
        }

        return $this->loader;
    }
}
