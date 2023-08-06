<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

enum CommentsPostStrategy: string
{
    case Single = 'single';
    case SingleAppend = 'single_append';
    case Null = 'null';
    case New = 'new';
}
