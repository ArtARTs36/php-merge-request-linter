<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API;

use ArtARTs36\Normalizer\Value\Selectors\Key;

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
        #[Key('has_conflicts')]
        public readonly bool $hasConflicts,
        #[Key('source_branch')]
        public readonly string $sourceBranch,
        #[Key('target_branch')]
        public readonly string $targetBranch,
        #[Key('author.username')]
        public readonly string $authorLogin,
        #[Key('draft')]
        public readonly bool $isDraft,
        #[Key('merge_status')]
        public readonly string $mergeStatus,
        public array $changes,
        #[Key('created_at')]
        public readonly \DateTimeImmutable $createdAt,
        #[Key('web_url')]
        public readonly string $uri,
    ) {
        //
    }

    public function canMerge(): bool
    {
        return $this->mergeStatus === self::MERGE_STATUS_CAN_BE_MERGED;
    }
}
