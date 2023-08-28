<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\User;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigLoader;

class ConfigResolver implements \ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigResolver
{
    public function __construct(
        private PathResolver $path,
        private ConfigLoader $loader,
    ) {
        //
    }

    public function resolve(User $user, int $configSubjects = Config::SUBJECT_ALL): ResolvedConfig
    {
        $path = $this->path->resolve($user);

        return new ResolvedConfig($this->loader->load($path, $configSubjects), $path);
    }
}
