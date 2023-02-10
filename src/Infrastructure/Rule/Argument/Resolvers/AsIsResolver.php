<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Support\Reflector\ParameterType;

final class AsIsResolver implements ArgumentResolver
{
    public function resolve(ParameterType $type, mixed $value): mixed
    {
        return $value;
    }
}
