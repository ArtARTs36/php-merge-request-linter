<?php

namespace ArtARTs36\MergeRequestLinter\Request\Data\Diff;

enum Type: string
{
    case OLD = 'old';
    case NEW = 'new';
    case NOT_CHANGES = 'not_changes';
}
