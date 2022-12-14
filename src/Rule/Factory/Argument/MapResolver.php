<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Argument;

use ArtARTs36\MergeRequestLinter\Contracts\ArgResolver;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;

class MapResolver implements ArgResolver
{
    public const SUPPORT_TYPE = Map::class;

    public function resolve(mixed $value): mixed
    {
        if (! is_array($value)) {
            throw new \Exception(sprintf('Value %s cant converted to Map', $value));
        }

        if (array_is_list($value)) {
            return Map::fromList($value);
        }

        return new Map($value);
    }
}
