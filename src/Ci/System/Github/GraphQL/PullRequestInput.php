<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System\Github\GraphQL;

class PullRequestInput
{
    public function __construct(
        public readonly string $owner,
        public readonly string $repository,
        public readonly int $requestId,
    ) {
        //
    }
}
