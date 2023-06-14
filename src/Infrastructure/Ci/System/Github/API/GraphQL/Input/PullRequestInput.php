<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input;

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
