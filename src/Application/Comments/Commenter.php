<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments;

use ArtARTs36\MergeRequestLinter\Application\Comments\Exceptions\SendCommentException;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
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
    public function postComment(MergeRequest $request, LintResult $result, CommentsConfig $config): void;
}
