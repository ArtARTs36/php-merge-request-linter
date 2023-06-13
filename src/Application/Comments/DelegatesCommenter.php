<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments;

use ArtARTs36\MergeRequestLinter\Application\Comments\Exceptions\SendCommentException;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use Psr\Log\LoggerInterface;

final class DelegatesCommenter implements Commenter
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly CommenterFactory $commenterFactory,
    ) {
        //
    }

    public function postComment(MergeRequest $request, LintResult $result, CommentsConfig $config): void
    {
        $this->logger->info(sprintf(
            'Sending comment on merge request "%s"',
            $request->title,
        ));

        try {
            $this
                ->commenterFactory
                ->create($config->postStrategy)
                ->postComment($request, $result, $config);

            $this->logger->info(sprintf(
                'Comment on merge request "%s" was sent',
                $request->title,
            ));
        } catch (SendCommentException $e) {
            $this->logger->error(sprintf(
                'Comment on merge request "%s" didn\'t sent: %s',
                $request->title,
                $e->getMessage(),
            ));

            throw $e;
        }
    }
}
