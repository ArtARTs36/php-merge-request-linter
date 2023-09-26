<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input;

/**
 * @codeCoverageIgnore
 */
readonly class CommentInput
{
    public function __construct(
        public string $apiUrl,
        public int    $projectId,
        public int    $requestNumber,
        public string $comment,
    ) {
    }
}
