<?php

namespace ArtARTs36\MergeRequestLinter\Note;

enum NoteSeverity: string
{
    case Normal = 'normal';
    case Fatal = 'fatal';
}
