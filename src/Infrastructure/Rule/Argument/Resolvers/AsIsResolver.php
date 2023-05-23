<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Shared\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;

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
