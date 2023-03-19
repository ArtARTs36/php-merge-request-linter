<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration;

use ArtARTs36\MergeRequestLinter\Shared\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\ArgNotSupportedException;

/**
 * Argument resolver.
 * @phpstan-type ArgumentValue = scalar|array<mixed>
 */
interface ArgumentResolver
{
    /**
     * Resolve argument.
     * @param ArgumentValue $value
     * @throws ArgNotSupportedException
     */
    public function resolve(Type $type, mixed $value): mixed;
}
