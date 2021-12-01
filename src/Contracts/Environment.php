<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Exception\EnvironmentDataKeyNotFound;

/**
 * Environment
 */
interface Environment
{
    /**
     * Get string value of Environment
     * @throws EnvironmentDataKeyNotFound
     */
    public function getString(string $key): string;

    /**
     * Get integer value of Environment
     * @throws EnvironmentDataKeyNotFound
     */
    public function getInt(string $key): int;
}
