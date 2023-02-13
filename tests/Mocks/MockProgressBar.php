<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Presentation\Console\Contracts\ProgressBar;

final class MockProgressBar implements ProgressBar
{
    public int $progress = 0;

    public bool $finished = false;

    public function max(int $max): void
    {
        //
    }

    public function add(): void
    {
        ++$this->progress;
    }

    public function finish(): void
    {
        $this->finished = true;
    }
}
