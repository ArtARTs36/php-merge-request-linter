<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text;

use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Exceptions\TextRenderingFailedException;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;

/**
 * Interface for text rendering.
 */
interface TextRenderer
{
    /**
     * Render text.
     * @param Map<string, mixed> $data
     * @throws TextRenderingFailedException
     */
    public function render(string $text, Map $data): string;
}
