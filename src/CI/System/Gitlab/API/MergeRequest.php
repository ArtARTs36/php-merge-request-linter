<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Gitlab\API;

class MergeRequest
{
    /**
     * @param array<string> $labels
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
    ) {
        //
    }
}
