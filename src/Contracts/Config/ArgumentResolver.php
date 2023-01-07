<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Config;

use ArtARTs36\MergeRequestLinter\Exception\ArgNotSupportedException;

/**
 * Argument resolver.
 */
interface ArgumentResolver
{
    /**
     * Resolve argument.
     * @throws ArgNotSupportedException
     */
    public function resolve(mixed $value): mixed;
}
