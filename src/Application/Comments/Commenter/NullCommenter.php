<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Commenter;

use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\Commenter;
use ArtARTs36\MergeRequestLinter\Application\Comments\MakingComment;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * @codeCoverageIgnore
 */
final class NullCommenter implements Commenter
{
    public function postComment(MergeRequest $request, MakingComment $comment): void
    {
        //
    }
}
