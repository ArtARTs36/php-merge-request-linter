<?php

namespace ArtARTs36\MergeRequestLinter\Console\Interaction;

use ArtARTs36\MergeRequestLinter\Contracts\LintEventSubscriber;
use ArtARTs36\MergeRequestLinter\Contracts\ProgressBar;

class ProgressBarLintSubscriber implements LintEventSubscriber
{
    public function __construct(
        private ProgressBar $progressBar,
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
}
