<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Resolver;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\Exception\ConfigNotFound;

class PathResolver
{
    private const FILE_NAME = '.mr-linter';

    public function __construct(
        private FileSystem $files,
    ) {
        //
    }

    /**
     * @throws ConfigNotFound
     */
    public function resolve(string $directory, ?string $userPath = null): string
    {
        if ($userPath !== null) {
            return $this->resolveUserPath($userPath);
        }

        $path = $this->findConfigPath($directory);

        if ($path === false) {
            throw ConfigNotFound::fromDirectory($directory);
        }

        return $path;
    }

    private function resolveUserPath(string $userPath): string
    {
        if (! $this->files->exists($userPath)) {
            throw ConfigNotFound::fromPath($userPath);
        }

        return realpath($userPath);
    }

    private function findConfigPath(string $directory): string|false
    {
        $paths = glob(sprintf('%s/%s.*', $directory, self::FILE_NAME));

        return current($paths);
    }
}
