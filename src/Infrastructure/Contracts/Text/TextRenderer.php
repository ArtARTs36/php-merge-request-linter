<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;

/**
 * Interface for text rendering.
 */
interface TextRenderer
{
    /**
     * Render text.
     * @param Map<string, mixed> $data
     */
    public function render(string $text, Map $data): string;
}
