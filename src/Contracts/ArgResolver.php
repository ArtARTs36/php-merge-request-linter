<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

/**
 * Argument resolver.
 */
interface ArgResolver
{
    /**
     * Resolve argument.
     */
    public function resolve(mixed $value): mixed;
}
