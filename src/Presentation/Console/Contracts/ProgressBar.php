<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Contracts;

/**
 * Interface for UI Progress Bar.
 */
interface ProgressBar
{
    /**
     * Set max length.
     */
    public function max(int $max): void;

    /**
     * Add progress.
     */
    public function add(): void;

    /**
     * Finish progress bar.
     */
    public function finish(): void;
}
