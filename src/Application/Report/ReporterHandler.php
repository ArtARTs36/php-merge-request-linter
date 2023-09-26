<?php

namespace ArtARTs36\MergeRequestLinter\Application\Report;

use ArtARTs36\MergeRequestLinter\Application\Report\Reporter\Reporter;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintFinishedEvent;
use ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent\Listener;

class ReporterHandler implements Listener
{
    public function __construct(
        private readonly Reporter $reporter,
    ) {
    }

    public function handle(object $event): void
    {
        if (! $event instanceof LintFinishedEvent) {
            throw new \LogicException(sprintf(
                'ReporterHandler expects event of %s, actual: %s',
                LintFinishedEvent::class,
                $event::class,
            ));
        }

        $this->reporter->report($event->request, $event->result);
    }
}
