<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Contracts\ProgressBar;

final class MockProgressBar implements ProgressBar
{
    public int $progress = 0;

    public bool $finished = false;

    public function add(): void
    {
        ++$this->progress;
    }

    public function finish(): void
    {
        $this->finished = true;
    }
}
