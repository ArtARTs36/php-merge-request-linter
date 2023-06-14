<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments;

use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

final class SingleCommenter extends CiCommenter
{
    protected function doPostComment(MergeRequest $request, MakingComment $comment): void
    {
        $this->logger->info(sprintf(
            '[SingleCommenter] Fetching first comment for MR with id "%s" by current user',
            $request->id,
        ));

        $firstComment = $this->ci->getFirstCommentOnMergeRequestByCurrentUser($request);

        $this->logger->info('[SingleCommenter] First comment by current user not found');

        if ($firstComment === null) {
            $this->logger->info(sprintf(
                '[SingleCommenter] Creating comment for MR with id "%s"',
                $request->id,
            ));

            $this->ci->postCommentOnMergeRequest($request, $comment->message);

            $this->logger->info(sprintf(
                '[SingleCommenter] Comment for MR with id "%s" was created',
                $request->id,
            ));
        } else {
            $this->logger->info(sprintf(
                '[SingleCommenter] Updating comment for MR with id "%s"',
                $request->id,
            ));

            $this->ci->updateComment(new Comment(
                $firstComment->id,
                $comment->message,
            ));

            $this->logger->info(sprintf(
                '[SingleCommenter] Comment for MR with id "%s" was updated',
                $request->id,
            ));
        }
    }
}
