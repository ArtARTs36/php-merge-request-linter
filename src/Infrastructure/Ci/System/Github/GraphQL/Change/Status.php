<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Change;

enum Status: string
{
    case Modified = 'modified';
    case Added = 'added';
    case Removed = 'removed';
    case Renamed = 'renamed';
    case Copied = 'copied';
    case Changed = 'changed';
    case Unknown = 'Unknown';

    public static function create(string $value): self
    {
        return self::tryFrom($value) ?? self::Unknown;
    }
}
