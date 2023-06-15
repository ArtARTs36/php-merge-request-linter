<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Commenter;

use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\Commenter;
use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\CommentMessageCreator;
use ArtARTs36\MergeRequestLinter\Application\Comments\Exceptions\SendCommentException;
use ArtARTs36\MergeRequestLinter\Application\Comments\MakingComment;
use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use Psr\Log\LoggerInterface;

abstract class CiCommenter implements Commenter
{
    /**
     * @throws SendCommentException
     */
    abstract protected function doPostComment(MergeRequest $request, MakingComment $comment): void;

    public function __construct(
        protected readonly CiSystem $ci,
        private readonly CommentMessageCreator $messageCreator,
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

        $this->doPostComment($request, new MakingComment($message));
    }
}
