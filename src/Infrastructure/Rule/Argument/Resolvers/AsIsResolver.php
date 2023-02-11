<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Common\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;

final class AsIsResolver implements ArgumentResolver
{
    public function resolve(Type $type, mixed $value): mixed
    {
        return $value;
    }
}
