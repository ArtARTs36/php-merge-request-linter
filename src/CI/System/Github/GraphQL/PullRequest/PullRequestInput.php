<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest;

class PullRequestInput
{
    public function __construct(
        public readonly string $graphqlUrl,
        public readonly string $owner,
        public readonly string $repository,
        public readonly int $requestId,
    ) {
        //
    }
}
