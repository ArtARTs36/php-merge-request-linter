<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\ArrayConfigHydrator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextDecoder;

class ArrayLoader implements ConfigLoader
{
    public function __construct(
        private readonly FileSystem          $files,
        private readonly TextDecoder         $text,
        private readonly ArrayConfigHydrator $hydrator,
    ) {
        //
    }

    public function load(string $path): Config
    {
        return $this->hydrator->hydrate(
            $this->text->decode($this->files->getFileContent($path)),
        );
    }
}
