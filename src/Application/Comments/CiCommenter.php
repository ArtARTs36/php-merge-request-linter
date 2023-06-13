<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments;

use ArtARTs36\MergeRequestLinter\Application\Comments\Message\MessageCreator;
use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use Psr\Log\LoggerInterface;

abstract class CiCommenter implements Commenter
{
    abstract protected function doPostComment(MergeRequest $request, Comment $comment): void;

    public function __construct(
        protected readonly CiSystem $ci,
        private readonly MessageCreator $messageCreator,
        protected readonly LoggerInterface $logger,
    ) {
        //
    }

    public function postComment(MergeRequest $request, LintResult $result, CommentsConfig $config): void
    {
        $message = $this->messageCreator->create($request, $result, $config);

        if ($message === null) {
            $this->logger->info('[CiCommenter] Comment message not found');

            return;
        }

        $this->doPostComment($request, new Comment($message));
    }
}
