<?php

namespace ArtARTs36\MergeRequestLinter\Domain\ToolInfo;

/**
 * ToolInfo.
 */
interface ToolInfo
{
    /**
     * Get tool the latest version.
     */
    public function getLatestVersion(): ?Tag;

    /**
     * Used tool as PHAR.
     */
    public function usedAsPhar(): bool;
}
