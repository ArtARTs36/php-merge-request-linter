<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders;

use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Support\File\File;

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
