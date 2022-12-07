<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Resolver;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\Exception\ConfigInvalidException;

class PathResolver
{
    private const FILE_NAME = '.mr-linter';

    public function __construct(
        private FileSystem $files,
    ) {
        //
    }

    public function resolve(string $directory, ?string $userFormat = null): string
    {
        if ($userFormat !== null) {
            $path = $this->buildPath($directory, $userFormat);

            if ($this->files->exists($path)) {
                throw new ConfigInvalidException('Config not found');
            }

            return $path;
        }

        $paths = glob(sprintf('%s/%s.*', $directory, self::FILE_NAME));
        $path = current($paths);

        if ($path === false) {
            throw new ConfigInvalidException('Config not found');
        }

        return $path;
    }

    private function buildPath(string $directory, string $format): string
    {
        return sprintf('%s/%s.%s', $directory, self::FILE_NAME, $format);
    }
}
