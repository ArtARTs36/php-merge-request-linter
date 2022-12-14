<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Argument;

use ArtARTs36\MergeRequestLinter\Contracts\ArgResolver;
use ArtARTs36\MergeRequestLinter\Support\Set;

class SetResolver implements ArgResolver
{
    public const SUPPORT_TYPE = Set::class;

    public function resolve(mixed $value): mixed
    {
        if (! is_array($value)) {
            throw new \Exception(sprintf('Value %s cant converted to Map', $value));
        }

        return Set::fromList($value);
    }
}
