<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Commenter;

use ArtARTs36\MergeRequestLinter\Application\Comments\Exceptions\SendCommentException;
use ArtARTs36\MergeRequestLinter\Application\Comments\MakingComment;
use ArtARTs36\MergeRequestLinter\Domain\CI\PostCommentException;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

final class NewCommenter extends CiCommenter
{
    public function postComment(MergeRequest $request, MakingComment $comment): void
    {
        try {
            $this->logger->info(sprintf(
                '[NewCommenter] sending comment on merge request with id "%s" through CI "%s"',
                $request->id,
                $this->ci->getName(),
            ));

            $this->ci->postCommentOnMergeRequest($request, $comment->message);

            $this->logger->info(sprintf(
                '[NewCommenter] comment on merge request with id "%s" was sent',
                $request->id,
            ));
        } catch (PostCommentException $e) {
            $this->logger->error(sprintf(
                '[NewCommenter] comment on merge request with id "%s" was failed: %s',
                $request->id,
                $e->getMessage(),
            ));

            throw new SendCommentException($e->getMessage(), previous: $e);
        }
    }
}
