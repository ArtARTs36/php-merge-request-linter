<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Contracts;

/**
 * Interface for UI Progress Bar.
 */
interface ProgressBar
{
    /**
     * Add progress.
     */
    public function add(): void;

    /**
     * Finish progress bar.
     */
    public function finish(): void;
}
