<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment;

/**
 * Environment.
 */
interface Environment
{
    /**
     * Check has key in environment
     */
    public function has(string $key): bool;

    /**
     * Get string value of Environment
     * @throws EnvironmentVariableNotFoundException
     */
    public function getString(string $key): string;

    /**
     * Get integer value of Environment
     * @throws EnvironmentVariableNotFoundException
     */
    public function getInt(string $key): int;
}
