<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Argument;

use ArtARTs36\MergeRequestLinter\Contracts\Config\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Support\Reflector\ParameterType;

class AsIsResolver implements ArgumentResolver
{
    public function resolve(ParameterType $type, mixed $value): mixed
    {
        return $value;
    }
}
