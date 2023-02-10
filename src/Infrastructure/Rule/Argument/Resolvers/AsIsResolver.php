<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Argument\Resolvers;

use ArtARTs36\MergeRequestLinter\Common\Reflector\ParameterType;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;

final class AsIsResolver implements ArgumentResolver
{
    public function resolve(ParameterType $type, mixed $value): mixed
    {
        return $value;
    }
}
