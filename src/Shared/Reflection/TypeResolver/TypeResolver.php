<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;

/**
 * Argument resolver.
 */
interface TypeResolver
{
    /**
     * Check can resolve object.
     */
    public function canResolve(Type $type, mixed $value): bool;

    /**
     * Resolve argument.
     * @param mixed $value
     * @throws ValueInvalidException
     */
    public function resolve(Type $type, mixed $value): mixed;
}
