<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input;

/**
 * @codeCoverageIgnore
 */
readonly class GetCommentsInput
{
    public function __construct(
        public PullRequestInput $pullRequest,
        public int              $page,
    ) {
    }
}
