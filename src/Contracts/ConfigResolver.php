<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Configuration\Resolver\ResolvedConfig;

/**
 * Config resolver.
 */
interface ConfigResolver
{
    /**
     * Resolve config instance.
     */
    public function resolve(string $directory, ?string $userPath = null): ResolvedConfig;
}
