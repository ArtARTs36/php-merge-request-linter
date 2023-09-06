<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Change\Change;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;

class PullRequest
{
    private const MERGEABLE_STATE_CONFLICTING = 'CONFLICTING';
    private const MERGEABLE_STATE_MERGEABLE = 'MERGEABLE';

    /**
     * @param array<string> $labels
     * @param Map<string, Change> $changes
     * @param int<0, max> $changedFiles
     */
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $bodyMarkdown,
        public readonly string $bodyText,
        public readonly array $labels,
        public readonly string $mergeable,
        public readonly string $headRefName,
        public readonly string $baseRefName,
        public readonly int $changedFiles,
        public readonly string $authorLogin,
        public readonly bool $isDraft,
        public readonly \DateTimeImmutable $createdAt,
        public readonly string $uri,
        public Map $changes = new ArrayMap([]),
    ) {
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
