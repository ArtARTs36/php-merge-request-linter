<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader\Loaders;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Exception\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Support\File;

class CompositeLoader implements ConfigLoader
{
    /**
     * @param array<string, ConfigLoader> $loadersByFormat
     */
    public function __construct(
        private readonly array $loadersByFormat,
    ) {
        //
    }

    public function load(string $path): Config
    {
        $format = File::extension($path);

        if (! isset($this->loadersByFormat[$format])) {
            throw new ConfigInvalidException(sprintf('Config format %s not supported', $format));
        }

        return $this->loadersByFormat[$format]->load($path);
    }
}
