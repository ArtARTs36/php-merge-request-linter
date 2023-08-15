<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver\ResolvedConfig;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\User;

/**
 * Config resolver.
 */
interface ConfigResolver
{
    /**
     * Resolve config instance.
     */
    public function resolve(User $user, int $configSubjects = Config::SUBJECT_ALL): ResolvedConfig;
}
