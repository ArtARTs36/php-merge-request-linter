<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Note;

enum NoteSeverity: string
{
    case Normal = 'normal';
    case Fatal = 'fatal';
}
