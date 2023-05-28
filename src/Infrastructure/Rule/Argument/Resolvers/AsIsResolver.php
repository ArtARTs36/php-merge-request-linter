<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;

final class AsIsResolver implements ArgumentResolver
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
