<?php

namespace ArtARTs36\MergeRequestLinter\Domain\ToolInfo;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Tag\Tag;

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
