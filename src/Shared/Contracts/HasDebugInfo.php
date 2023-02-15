<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Contracts;

/**
 * Interface for debug objects.
 */
interface HasDebugInfo
{
    /**
     * Get debug info.
     * @return array<string, mixed>
     */
    public function __debugInfo(): array;
}
