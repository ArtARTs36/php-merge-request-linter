<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Configuration\Resolver\ResolvedConfig;
use ArtARTs36\MergeRequestLinter\Configuration\User;

/**
 * Config resolver.
 */
interface ConfigResolver
{
    /**
     * Resolve config instance.
     */
    public function resolve(User $user): ResolvedConfig;
}
