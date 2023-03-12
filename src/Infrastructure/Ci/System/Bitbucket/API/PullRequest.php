<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API;

use ArtARTs36\Str\Facade\Str;

class PullRequest
{
    public function __construct(
        public readonly int                $id,
        public readonly string             $title,
        public readonly string             $authorNickname,
        public readonly string             $sourceBranch,
        public readonly string             $targetBranch,
        public readonly \DateTimeImmutable $createdAt,
        public readonly string             $uri,
        public readonly string             $description,
        public readonly string             $state,
    ) {
        //
    }

    public function canMerge(): bool
    {
        return $this->state === 'OPEN';
    }

    public function isDraft(): bool
    {
        return Str::startsWith($this->title, 'Draft:');
    }
}
