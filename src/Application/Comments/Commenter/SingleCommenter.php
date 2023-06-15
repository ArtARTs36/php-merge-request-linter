<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Commenter;

use ArtARTs36\MergeRequestLinter\Application\Comments\MakingComment;
use ArtARTs36\MergeRequestLinter\Application\Comments\Message\MessageCreator;
use ArtARTs36\MergeRequestLinter\Application\Comments\Message\UpdatingMessageFormatter;
use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use Psr\Log\LoggerInterface;

final class SingleCommenter extends CiCommenter
{
    public function __construct(
        CiSystem $ci,
        LoggerInterface $logger,
        private readonly UpdatingMessageFormatter $updatingMessageFormatter,
    ) {
        parent::__construct($ci, $logger);
    }

    public function postComment(MergeRequest $request, MakingComment $comment): void
    {
        $this->logger->info(sprintf(
            '[SingleCommenter] Fetching first comment for MR with id "%s" by current user',
            $request->id,
        ));

        $firstComment = $this->ci->getFirstCommentOnMergeRequestByCurrentUser($request);

        if ($firstComment === null) {
            $this->createComment($request, $comment);

            return;
        }

        $this->updateCommentIfHaveNewMessage($request->id, $firstComment, $comment);
    }

    private function createComment(MergeRequest $request, MakingComment $makingComment): void
    {
        $this->logger->info('[SingleCommenter] First comment by current user not found');

        $this->logger->info(sprintf(
            '[SingleCommenter] Creating comment for MR with id "%s"',
            $request->id,
        ));

        $this->ci->postCommentOnMergeRequest($request, $makingComment->message);

        $this->logger->info(sprintf(
            '[SingleCommenter] Comment for MR with id "%s" was created',
            $request->id,
        ));
    }

    private function updateCommentIfHaveNewMessage(string $requestId, Comment $firstComment, MakingComment $makingComment): void
    {
        $this->logger->info(sprintf(
            '[SingleCommenter] Updating comment with id "%s" for MR with id "%s"',
            $firstComment->id,
            $requestId,
        ));

        $message = $this->updatingMessageFormatter->formatMessage($firstComment->message, $makingComment->message);

        if ($firstComment->message === $message) {
            $this->logger->info(sprintf(
                '[SingleCommenter] Updating comment with id "%s" for MR with id "%s" was skipped: messages identical',
                $firstComment->id,
                $requestId,
            ));

            return;
        }

        $this->updateComment($requestId, new Comment(
            $firstComment->id,
            $message,
        ));
    }

    private function updateComment(string $requestId, Comment $comment): void
    {
        $this->ci->updateComment($comment);

        $this->logger->info(sprintf(
            '[SingleCommenter] Comment for MR with id "%s" was updated',
            $requestId,
        ));
    }
}
