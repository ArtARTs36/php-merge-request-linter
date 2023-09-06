<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Change;

readonly class MergeRequest
{
    private const MERGE_STATUS_CAN_BE_MERGED = 'can_be_merged';

    /**
     * @param array<string> $labels
     * @param array<Change> $changes
     */
    public function __construct(
        public int $id,
        public int $number,
        public string $title,
        public string $description,
        public array $labels,
        public bool $hasConflicts,
        public string $sourceBranch,
        public string $targetBranch,
        public string $authorLogin,
        public bool $isDraft,
        public string $mergeStatus,
        public array $changes,
        public \DateTimeImmutable $createdAt,
        public string $uri,
    ) {
    }

    public function canMerge(): bool
    {
        return $this->mergeStatus === self::MERGE_STATUS_CAN_BE_MERGED;
    }
}
