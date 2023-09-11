<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input;

/**
 * @codeCoverageIgnore
 */
readonly class CreateCommentInput
{
    public function __construct(
        public string $projectKey,
        public string $repoName,
        public int    $requestId,
        public string $comment,
    ) {
    }
}
