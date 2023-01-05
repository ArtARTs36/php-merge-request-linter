<?php

namespace ArtARTs36\MergeRequestLinter\Console\Interaction;

use ArtARTs36\MergeRequestLinter\Contracts\IO\Printer;
use ArtARTs36\MergeRequestLinter\Contracts\IO\ProgressBar;
use ArtARTs36\MergeRequestLinter\Contracts\Linter\LintEventSubscriber;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

class ProgressBarLintSubscriber implements LintEventSubscriber
{
    public function __construct(
        private readonly ProgressBar $progressBar,
        private readonly Printer $printer,
        private readonly bool $isDebug,
    ) {
        //
    }

    public function success(string $ruleName): void
    {
        $this->progressBar->add();
    }

    public function fail(string $ruleName): void
    {
        $this->progressBar->add();
    }

    public function stopOn(string $ruleName): void
    {
        $this->progressBar->finish();
    }

    public function started(MergeRequest $request): void
    {
        if (! $this->isDebug) {
            return;
        }

        $this->printer->printObject($request);
    }
}
