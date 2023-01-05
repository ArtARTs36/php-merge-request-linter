<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Exception\ArgNotSupportedException;

/**
 * Argument resolver.
 */
interface ArgResolver
{
    /**
     * Resolve argument.
     * @throws ArgNotSupportedException
     */
    public function resolve(mixed $value): mixed;
}
