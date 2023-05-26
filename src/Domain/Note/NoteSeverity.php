<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Note;

/**
 * @codeCoverageIgnore
 */
enum NoteSeverity: string
{
    case Normal = 'normal';
    case Fatal = 'fatal';

    case Warning = 'warning';
}
