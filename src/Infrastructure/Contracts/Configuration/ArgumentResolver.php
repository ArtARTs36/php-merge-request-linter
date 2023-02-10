<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration;

use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\ArgNotSupportedException;
use ArtARTs36\MergeRequestLinter\Support\Reflector\ParameterType;

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
    public function resolve(ParameterType $type, mixed $value): mixed;
}
