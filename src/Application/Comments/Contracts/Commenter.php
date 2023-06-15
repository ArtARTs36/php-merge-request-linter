<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Contracts;

use ArtARTs36\MergeRequestLinter\Application\Comments\Exceptions\SendCommentException;
use ArtARTs36\MergeRequestLinter\Application\Comments\MakingComment;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * Commenter for merge requests.
 */
interface Commenter
{
    /**
     * Post comment on merge request.
     * @throws SendCommentException
     */
    public function postComment(MergeRequest $request, MakingComment $comment): void;
}
