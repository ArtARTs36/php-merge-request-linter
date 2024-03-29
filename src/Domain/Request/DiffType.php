<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Request;

/**
 * @codeCoverageIgnore
 */
enum DiffType: string
{
    case OLD = 'old';
    case NEW = 'new';
    case NOT_CHANGES = 'not_changes';
}
