<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;

final class AsIsResolver implements TypeResolver
{
    public function canResolve(Type $type, mixed $value): bool
    {
        return true;
    }

    public function resolve(Type $type, mixed $value): mixed
    {
        return $value;
    }
}
