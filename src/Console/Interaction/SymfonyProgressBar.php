<?php

namespace ArtARTs36\MergeRequestLinter\Console\Interaction;

use ArtARTs36\MergeRequestLinter\Contracts\IO\ProgressBar;

final class SymfonyProgressBar implements ProgressBar
{
    public function __construct(
        private \Symfony\Component\Console\Helper\ProgressBar $bar,
    ) {
        //
    }

    public function add(): void
    {
        $this->bar->advance();
    }

    public function finish(): void
    {
        $this->bar->finish();
    }
}
