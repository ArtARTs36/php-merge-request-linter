<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Note;

/**
 * Note after linting.
 */
interface Note
{
    /**
     * Get Note Color.
     */
    public function getSeverity(): NoteSeverity;

    /**
     * Get note description.
     */
    public function getDescription(): string;

    /**
     * Get note description.
     */
    public function __toString(): string;
}
