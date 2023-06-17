<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input;

class GetCommentsInput
{
    public function __construct(
        public readonly PullRequestInput $pullRequest,
        public readonly int $page,
    ) {
        //
    }
}
