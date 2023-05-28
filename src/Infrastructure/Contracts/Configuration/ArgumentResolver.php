<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration;

use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ValueInvalidException;

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
     * @throws ValueInvalidException
     */
    public function resolve(Type $type, mixed $value): mixed;
}
