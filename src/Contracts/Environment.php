<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

/**
 * Environment
 */
interface Environment
{
    /**
     * Get string value of Environment
     */
    public function getString(string $key): ?string;

    /**
     * Get integer value of Environment
     */
    public function getInt(string $key): ?int;
}
