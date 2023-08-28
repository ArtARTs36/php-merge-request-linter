<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders;

use ArtARTs36\MergeRequestLinter\Shared\File\File;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigLoader;

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

    public function load(string $path, int $subjects = Config::SUBJECT_ALL): Config
    {
        $format = File::extension($path);

        if (! isset($this->loadersByFormat[$format])) {
            throw new ConfigInvalidException(sprintf('Config format %s not supported', $format));
        }

        return $this->loadersByFormat[$format]->load($path, $subjects);
    }
}
