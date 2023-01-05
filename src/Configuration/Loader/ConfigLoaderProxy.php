<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigLoader;

class ConfigLoaderProxy implements ConfigLoader
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
