<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

enum CommentsPostStrategy: string
{
    case Single = 'single';
    case Null = 'null';
    case New = 'new';
}
