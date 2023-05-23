<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration;

use ArtARTs36\MergeRequestLinter\Shared\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\ArgNotSupportedException;

/**
 * Argument resolver.
 */
interface ArgumentResolver
{
    /**
     * Check can resolve object.
     */
    public function canResolve(Type $type, mixed $value): bool;

    /**
     * Resolve argument.
     * @param mixed $value
     * @throws ArgNotSupportedException
     */
    public function resolve(Type $type, mixed $value): mixed;
}
