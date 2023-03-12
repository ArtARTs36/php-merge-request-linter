<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API;

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
    ) {
        //
    }
}
