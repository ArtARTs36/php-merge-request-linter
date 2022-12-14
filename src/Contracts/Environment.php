<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Exception\EnvironmentVariableNotFound;

/**
 * Environment
 */
interface Environment
{
    /**
     * Check has key in environment
     */
    public function has(string $key): bool;

    /**
     * Get string value of Environment
     * @throws EnvironmentVariableNotFound
     */
    public function getString(string $key): string;

    /**
     * Get integer value of Environment
     * @throws EnvironmentVariableNotFound
     */
    public function getInt(string $key): int;
}
