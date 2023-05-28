<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration;

use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\ArgNotSupportedException;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;

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
