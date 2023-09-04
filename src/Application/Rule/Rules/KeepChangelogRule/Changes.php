<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\KeepChangelogRule;

class Changes
{
    public const TYPE_ADDED = 'Added';
    public const TYPE_CHANGED = 'Changed';
    public const TYPE_DEPRECATED = 'Deprecated';
    public const TYPE_REMOVED = 'Removed';
    public const TYPE_FIXED = 'Fixed';
    public const TYPE_SECURITY = 'Security';

    public function __construct(
        public array $types = [
            self::TYPE_ADDED,
            self::TYPE_CHANGED,
            self::TYPE_DEPRECATED,
            self::TYPE_REMOVED,
            self::TYPE_FIXED,
            self::TYPE_SECURITY,
        ],
    ) {
    }
}
