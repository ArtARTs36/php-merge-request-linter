<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input;

/**
 * @codeCoverageIgnore
 */
readonly class PullRequestInput
{
    public function __construct(
        public string $graphqlUrl,
        public string $owner,
        public string $repository,
        public int    $requestId,
    ) {
        //
    }
}
