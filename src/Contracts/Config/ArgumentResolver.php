<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Config;

use ArtARTs36\MergeRequestLinter\Exception\ArgNotSupportedException;
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
