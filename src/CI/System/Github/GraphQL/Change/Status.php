<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\Change;

enum Status: string
{
    case Modified = 'modified';
    case Added = 'added';
    case Removed = 'removed';
    case Renamed = 'renamed';
    case Copied = 'copied';
    case Changed = 'changed';
}
