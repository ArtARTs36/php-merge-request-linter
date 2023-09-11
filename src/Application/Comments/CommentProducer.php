<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments;

use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\CommenterFactory;
use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\CommentMessageCreator;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use Psr\Log\LoggerInterface;

final class CommentProducer implements Contracts\CommentProducer
{
    public function __construct(
        private readonly CommentMessageCreator $messageCreator,
        private readonly LoggerInterface $logger,
        private readonly CommenterFactory $commenterFactory,
    ) {
    }

    public function produce(MergeRequest $request, LintResult $result, CommentsConfig $config): void
    {
        $message = $this->messageCreator->create($request, $result, $config);

        if ($message === null) {
            $this->logger->info(sprintf(
                '[CommentProducer] Comment message for merge request with id "%s" not found',
                $request->id,
            ));

            return;
        }

        $this
            ->commenterFactory
            ->create($config->postStrategy)
            ->postComment($request, new MakingComment($message));

        $this->logger->info(sprintf(
            '[CommentProducer] Comment for merge request with id "%s" was sent',
            $request->id,
        ));
    }
}
