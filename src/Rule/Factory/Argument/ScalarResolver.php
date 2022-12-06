<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Argument;

use ArtARTs36\MergeRequestLinter\Contracts\ArgResolver;

class ScalarResolver implements ArgResolver
{
    public function resolve(mixed $value): mixed
    {
        return $value;
    }
}
