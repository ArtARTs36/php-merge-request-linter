<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Argument;

use ArtARTs36\MergeRequestLinter\Contracts\Config\ArgumentResolver;

class AsIsResolver implements ArgumentResolver
{
    public function resolve(mixed $value): mixed
    {
        return $value;
    }
}
