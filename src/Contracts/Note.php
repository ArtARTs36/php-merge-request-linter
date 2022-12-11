<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Note\NoteColor;

/**
 * Note after linting
 */
interface Note
{
    /**
     * Get Note Color.
     */
    public function getColor(): NoteColor;

    /**
     * Get note description
     */
    public function getDescription(): string;

    /**
     * Get note description
     */
    public function __toString(): string;
}
