<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders;

use ArtARTs36\FileSystem\Contracts\FileNotFound;
use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\ConfigNotFound;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\ArrayConfigHydrator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\DecodingFailedException;
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

    public function load(string $path, int $subjects = Config::SUBJECT_ALL): Config
    {
        try {
            return $this->hydrator->hydrate(
                $this->text->decode($this->files->getFileContent($path)),
                $subjects,
            );
        } catch (DecodingFailedException $e) {
            throw new ConfigInvalidException(
                sprintf(
                'Failed to read config "%s": %s',
                pathinfo($path, PATHINFO_BASENAME),
                $e->getMessage()
            ),
                previous: $e,
            );
        } catch (FileNotFound $e) {
            throw ConfigNotFound::fromPath($path, $e);
        }
    }
}
