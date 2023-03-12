<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API;

class PullRequestInput
{
    public function __construct(
        public readonly string $projectKey,
        public readonly string $repoName,
        public readonly int    $requestId,
    ) {
        //
    }
}
