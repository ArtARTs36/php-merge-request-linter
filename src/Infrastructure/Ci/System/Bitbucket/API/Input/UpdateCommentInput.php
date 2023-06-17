<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input;

/**
 * @codeCoverageIgnore
 */
class UpdateCommentInput
{
    public function __construct(
        public readonly string $projectKey,
        public readonly string $repoName,
        public readonly int    $requestId,
        public readonly string $commentId,
        public readonly string $comment,
    ) {
        //
    }
}
