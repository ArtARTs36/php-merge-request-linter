<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Argument;

use ArtARTs36\MergeRequestLinter\Contracts\Config\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Exception\ArgNotSupportedException;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;

class MapResolver implements ArgumentResolver
{
    public const SUPPORT_TYPE = ArrayMap::class;

    public function resolve(mixed $value): mixed
    {
        if (! is_array($value)) {
            throw new ArgNotSupportedException(sprintf(
                'Arg with type %s not supported. Expected type: array',
                gettype($value),
            ));
        }

        return new ArrayMap($value);
    }
}
