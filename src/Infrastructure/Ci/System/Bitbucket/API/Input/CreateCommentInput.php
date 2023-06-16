<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input;

/**
 * @codeCoverageIgnore
 */
class CreateCommentInput
{
    public function __construct(
        public readonly string $projectKey,
        public readonly string $repoName,
        public readonly int    $requestId,
        public readonly string $comment,
    ) {
        //
    }
}
