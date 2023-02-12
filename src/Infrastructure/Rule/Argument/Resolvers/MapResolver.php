<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\ArgNotSupportedException;

final class MapResolver implements ArgumentResolver
{
    public const SUPPORT_TYPE = ArrayMap::class;

    public function resolve(Type $type, mixed $value): mixed
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
