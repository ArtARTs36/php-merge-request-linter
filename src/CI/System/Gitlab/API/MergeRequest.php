<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Gitlab\API;

class MergeRequest
{
    private const MERGE_STATUS_CAN_BE_MERGED = 'can_be_merged';

    /**
     * @param array<string> $labels
     * @param array<Change> $changes
     */
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly array $labels,
        public readonly bool $hasConflicts,
        public readonly string $sourceBranch,
        public readonly string $targetBranch,
        public readonly int $changedFilesCount,
        public readonly string $authorLogin,
        public readonly bool $isDraft,
        public readonly string $mergeStatus,
        public readonly array $changes,
    ) {
        //
    }

    public function canMerge(): bool
    {
        return $this->mergeStatus === self::MERGE_STATUS_CAN_BE_MERGED;
    }
}
