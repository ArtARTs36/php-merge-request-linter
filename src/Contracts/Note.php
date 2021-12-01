<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

/**
 * Note after linting
 */
interface Note
{
    /**
     * Get note description
     */
    public function getDescription(): string;

    /**
     * Get note description
     */
    public function __toString(): string;
}
