<?php

namespace ArtARTs36\MergeRequestLinter\Console\Interaction;

use ArtARTs36\MergeRequestLinter\Contracts\LintEventSubscriber;
use Symfony\Component\Console\Helper\ProgressBar;

class ProgressBarLintSubscriber implements LintEventSubscriber
{
    public function __construct(
        private ProgressBar $progressBar,
    ) {
        //
    }

    public function success(string $ruleName): void
    {
        $this->progressBar->advance();
    }

    public function fail(string $ruleName): void
    {
        $this->progressBar->advance();
    }

    public function stopOn(string $ruleName): void
    {
        $this->progressBar->finish();
    }
}
