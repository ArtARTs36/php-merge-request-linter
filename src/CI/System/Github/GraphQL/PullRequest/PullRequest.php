<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest;

use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\Change\Change;

class PullRequest
{
    private const MERGEABLE_STATE_CONFLICTING = 'CONFLICTING';
    private const MERGEABLE_STATE_MERGEABLE = 'MERGEABLE';

    /**
     * @param array<string> $labels
     * @param array<Change> $changes
     */
    public function __construct(
        public readonly string $title,
        public readonly string $bodyText,
        public readonly array $labels,
        public readonly string $mergeable,
        public readonly string $headRefName,
        public readonly string $baseRefName,
        public readonly string $authorLogin,
        public readonly bool $isDraft,
        public array $changes = [],
    ) {
        //
    }

    public function hasConflicts(): bool
    {
        return $this->mergeable === self::MERGEABLE_STATE_CONFLICTING;
    }

    public function canMerge(): bool
    {
        return $this->mergeable === self::MERGEABLE_STATE_MERGEABLE;
    }
}
