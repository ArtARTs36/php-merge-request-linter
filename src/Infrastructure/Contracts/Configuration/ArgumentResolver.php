<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration;

use ArtARTs36\MergeRequestLinter\Common\Reflector\ParameterType;
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
    public function resolve(ParameterType $type, mixed $value): mixed;
}
