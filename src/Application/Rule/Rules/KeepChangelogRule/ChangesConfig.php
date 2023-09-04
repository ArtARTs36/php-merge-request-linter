<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\KeepChangelogRule;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;

readonly class ChangesConfig
{
    public const TYPE_ADDED = 'Added';
    public const TYPE_CHANGED = 'Changed';
    public const TYPE_DEPRECATED = 'Deprecated';
    public const TYPE_REMOVED = 'Removed';
    public const TYPE_FIXED = 'Fixed';
    public const TYPE_SECURITY = 'Security';

    /** @var Set<string> */
    public Set $types;

    /**
     * @param Set<string>|null $types
     */
    public function __construct(
        ?Set $types = null,
    ) {
        $this->types = $types ?? Set::fromList([
            self::TYPE_ADDED,
            self::TYPE_CHANGED,
            self::TYPE_DEPRECATED,
            self::TYPE_REMOVED,
            self::TYPE_FIXED,
            self::TYPE_SECURITY,
        ]);
    }
}
