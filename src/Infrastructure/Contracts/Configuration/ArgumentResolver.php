<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration;

use ArtARTs36\MergeRequestLinter\Common\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\ArgNotSupportedException;

/**
 * Argument resolver.
 */
interface ArgumentResolver
{
    /**
     * Resolve argument.
     * @param scalar|array<mixed> $value
     * @throws ArgNotSupportedException
     */
    public function resolve(Type $type, mixed $value): mixed;
}
