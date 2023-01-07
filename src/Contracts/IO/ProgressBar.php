<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\IO;

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
