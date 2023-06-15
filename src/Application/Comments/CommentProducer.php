<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments;

use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\CommenterFactory;
use ArtARTs36\MergeRequestLinter\Application\Comments\Message\MessageCreator;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use Psr\Log\LoggerInterface;

final class CommentProducer implements Contracts\CommentProducer
{
    public function __construct(
        private readonly MessageCreator $messageCreator,
        private readonly LoggerInterface $logger,
        private readonly CommenterFactory $commenterFactory,
    ) {
        //
    }

    public function produce(MergeRequest $request, LintResult $result, CommentsConfig $config): void
    {
        $message = $this->messageCreator->create($request, $result, $config);

        if ($message === null) {
            $this->logger->info('[CommentProducer] Comment message not found');

            return;
        }

        $this
            ->commenterFactory
            ->create($config->postStrategy)
            ->postComment($request, new MakingComment($message));
    }
}
