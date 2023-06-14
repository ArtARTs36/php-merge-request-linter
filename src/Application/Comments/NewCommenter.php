<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

final class NewCommenter extends CiCommenter
{
    protected function doPostComment(MergeRequest $request, MakingComment $comment): void
    {
        $this->ci->postCommentOnMergeRequest($request, $comment->message);
    }
}
