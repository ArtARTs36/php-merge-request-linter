<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Listener;

use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\CommentProducer;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintFinishedEvent;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventListener;

final class LintFinishedListener implements EventListener
{
    public function __construct(
        private readonly CommentProducer $commentProducer,
        private readonly CommentsConfig  $config,
    ) {
        //
    }

    /**
     * @codeCoverageIgnore
     */
    public function name(): string
    {
        return 'send comment';
    }

    public function call(object $event): void
    {
        if (! $event instanceof LintFinishedEvent) {
            throw new \LogicException(sprintf(
                'LintFinishedListener expects LintFinishedEvent, but given %s',
                get_class($event),
            ));
        }

        $this->commentProducer->produce($event->request, $event->result, $this->config);
    }
}
