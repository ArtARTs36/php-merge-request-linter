<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Output;

use ArtARTs36\MergeRequestLinter\Presentation\Console\Contracts\ProgressBar;

final readonly class SymfonyProgressBar implements ProgressBar
{
    public function __construct(
        private \Symfony\Component\Console\Helper\ProgressBar $bar,
    ) {
    }

    public function max(int $max): void
    {
        $this->bar->setMaxSteps($max);
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
