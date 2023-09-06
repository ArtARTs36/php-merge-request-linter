<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver;

use ArtARTs36\FileSystem\Contracts\FileNotFound;
use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\ConfigNotFound;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\User;

class PathResolver
{
    private const FILE_NAME = '.mr-linter';

    public function __construct(
        private readonly FileSystem $files,
    ) {
    }

    /**
     * @throws ConfigNotFound
     */
    public function resolve(User $user): string
    {
        if ($user->customPath !== null) {
            return $this->resolveUserPath($user->customPath);
        }

        $path = $this->findConfigPath($user->workDirectory);

        if ($path === false) {
            throw ConfigNotFound::fromDirectory($user->workDirectory);
        }

        return $path;
    }

    private function resolveUserPath(string $userPath): string
    {
        try {
            return $this->files->getAbsolutePath($userPath);
        } catch (FileNotFound) {
            throw ConfigNotFound::fromPath($userPath);
        }
    }

    private function findConfigPath(string $directory): string|false
    {
        $paths = glob(sprintf('%s/%s.*', $directory, self::FILE_NAME));

        if ($paths === false) {
            return false;
        }

        return current($paths);
    }
}
