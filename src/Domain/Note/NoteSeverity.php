<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Note;

/**
 * @codeCoverageIgnore
 */
enum NoteSeverity: string
{
    case Fatal = 'fatal';

    case Error = 'error';

    case Warning = 'warning';
}
