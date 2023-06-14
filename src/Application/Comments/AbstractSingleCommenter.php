<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments;

use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

abstract class AbstractSingleCommenter extends CiCommenter
{
    abstract protected function createUpdatingMessage(Comment $comment, MakingComment $makingComment): string;

    protected function doPostComment(MergeRequest $request, MakingComment $comment): void
    {
        $this->logger->info(sprintf(
            '[SingleCommenter] Fetching first comment for MR with id "%s" by current user',
            $request->id,
        ));

        $firstComment = $this->ci->getFirstCommentOnMergeRequestByCurrentUser($request);

        if ($firstComment === null) {
            $this->logger->info('[SingleCommenter] First comment by current user not found');

            $this->logger->info(sprintf(
                '[SingleCommenter] Creating comment for MR with id "%s"',
                $request->id,
            ));

            $this->ci->postCommentOnMergeRequest($request, $comment->message);

            $this->logger->info(sprintf(
                '[SingleCommenter] Comment for MR with id "%s" was created',
                $request->id,
            ));

            return;
        }

        $this->logger->info(sprintf(
            '[SingleCommenter] Updating comment with id "%s" for MR with id "%s"',
            $firstComment->id,
            $request->id,
        ));

        $this->ci->updateComment(new Comment(
            $firstComment->id,
            $this->createUpdatingMessage($firstComment, $comment),
        ));

        $this->logger->info(sprintf(
            '[SingleCommenter] Comment for MR with id "%s" was updated',
            $request->id,
        ));
    }
}
