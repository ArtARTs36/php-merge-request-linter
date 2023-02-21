<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest;

/**
 * @codeCoverageIgnore
 */
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
