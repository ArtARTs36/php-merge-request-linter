<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments;

use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

final class SingleCommenter extends CiCommenter
{
    protected function doPostComment(MergeRequest $request, MakingComment $comment): void
    {
        $firstComment = $this->ci->getFirstCommentOnMergeRequestByCurrentUser($request);
    }
}
