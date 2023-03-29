<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API;

use ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\Str\Facade\Str;

class PullRequest
{
    /**
     * @param Map<string, array<DiffLine>> $changes
     */
    public function __construct(
        public readonly int                $id,
        public readonly string             $title,
        public readonly string             $authorNickname,
        public readonly string             $sourceBranch,
        public readonly string             $targetBranch,
        public readonly \DateTimeImmutable $createdAt,
        public readonly string             $uri,
        public readonly \ArtARTs36\Str\Str             $description,
        public readonly PullRequestState  $state,
        public readonly string            $diffUrl,
        public Map $changes = new ArrayMap([]),
    ) {
        //
    }

    public function canMerge(): bool
    {
        return $this->state === PullRequestState::Open;
    }

    public function isDraft(): bool
    {
        return Str::startsWith($this->title, 'Draft:');
    }
}
