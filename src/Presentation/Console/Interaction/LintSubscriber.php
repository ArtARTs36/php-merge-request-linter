<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Interaction;

use ArtARTs36\MergeRequestLinter\Contracts\IO\Printer;
use ArtARTs36\MergeRequestLinter\Contracts\IO\ProgressBar;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintFinishedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintStartedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\RuleWasFailedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\RuleWasSuccessfulEvent;

class LintSubscriber
{
    public function __construct(
        private readonly ProgressBar $progressBar,
        private readonly Printer $printer,
        private readonly bool $isDebug,
    ) {
        //
    }

    public function success(RuleWasSuccessfulEvent $event): void
    {
        $this->progressBar->add();
    }

    public function fail(RuleWasFailedEvent $event): void
    {
        $this->progressBar->add();
    }

    public function finished(LintFinishedEvent $event): void
    {
        $this->progressBar->finish();
    }

    public function started(LintStartedEvent $event): void
    {
        if (! $this->isDebug) {
            return;
        }

        $this->printer->printTitle('Merge Request properties:');
        $this->printer->printObject($event->request);
    }
}
