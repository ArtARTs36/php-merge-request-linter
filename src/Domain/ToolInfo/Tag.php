<?php

namespace ArtARTs36\MergeRequestLinter\Domain\ToolInfo;

/**
 * Interface for app Version.
 */
interface Tag
{
    /**
     * Get digits as string.
     */
    public function digit(): string;
}
