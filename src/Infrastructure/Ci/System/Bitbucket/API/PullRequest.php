<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API;

class PullRequest
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
    ) {
        //
    }
}
