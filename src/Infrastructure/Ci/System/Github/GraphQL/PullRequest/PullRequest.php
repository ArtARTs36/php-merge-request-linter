<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest;

use ArtARTs36\MergeRequestLinter\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Change\Change;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;

class PullRequest
{
    private const MERGEABLE_STATE_CONFLICTING = 'CONFLICTING';
    private const MERGEABLE_STATE_MERGEABLE = 'MERGEABLE';

    /**
     * @param array<string> $labels
     * @param Map<string, Change> $changes
     */
    public function __construct(
        public readonly string $title,
        public readonly string $bodyText,
        public readonly array $labels,
        public readonly string $mergeable,
        public readonly string $headRefName,
        public readonly string $baseRefName,
        public readonly int $changedFiles,
        public readonly string $authorLogin,
        public readonly bool $isDraft,
        public Map $changes = new ArrayMap([]),
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