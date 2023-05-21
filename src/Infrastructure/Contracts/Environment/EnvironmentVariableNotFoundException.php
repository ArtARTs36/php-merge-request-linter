<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment;

/**
 * Interface for exception to environment variable not found.
 */
interface EnvironmentVariableNotFoundException extends EnvironmentException
{
    /**
     * Get variable name.
     */
    public function getVarName(): string;
}
