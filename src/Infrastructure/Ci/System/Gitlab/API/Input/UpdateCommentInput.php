<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input;

/**
 * @codeCoverageIgnore
 */
final readonly class UpdateCommentInput extends CommentInput
{
    public function __construct(
        string     $apiUrl,
        int        $projectId,
        int        $requestNumber,
        string     $comment,
        public int $commentId,
    ) {
        parent::__construct($apiUrl, $projectId, $requestNumber, $comment);
    }
}
