<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\CommentInput;

class UpdateCommentInput extends CommentInput
{
    public function __construct(
        string $apiUrl,
        int $projectId,
        int $requestNumber,
        string $comment,
        public readonly int $commentId,
    ) {
        parent::__construct($apiUrl, $projectId, $requestNumber, $comment);
    }
}
