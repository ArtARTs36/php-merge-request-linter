<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Change;

/**
 * @codeCoverageIgnore
 */
enum Status: string
{
    case Modified = 'modified';
    case Added = 'added';
    case Removed = 'removed';
    case Renamed = 'renamed';
    case Copied = 'copied';
    case Changed = 'changed';
}
