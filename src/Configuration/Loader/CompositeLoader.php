<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Exception\ConfigInvalidException;

class CompositeLoader implements ConfigLoader
{
    /**
     * @param array<string, ConfigLoader> $loadersByFormat
     */
    public function __construct(
        private array $loadersByFormat,
    ) {
        //
    }

    public function load(string $path): Config
    {
        $format = mb_strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (! isset($this->loadersByFormat[$format])) {
            throw new ConfigInvalidException(sprintf('Config format %s not supported', $format));
        }

        return $this->loadersByFormat[$format]->load($path);
    }
}
