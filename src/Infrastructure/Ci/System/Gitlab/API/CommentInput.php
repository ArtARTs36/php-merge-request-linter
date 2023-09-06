<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API;

/**
 * @codeCoverageIgnore
 */
class CommentInput
{
    public function __construct(
        public readonly string $apiUrl,
        public readonly int $projectId,
        public readonly int $requestNumber,
        public readonly string $comment,
    ) {
    }
}
