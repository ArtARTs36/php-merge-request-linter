<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text;

use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Exceptions\TextRenderingFailedException;

/**
 * Interface for text rendering.
 */
interface TextRenderer
{
    /**
     * Render text.
     * @param array<string, mixed> $data
     * @throws TextRenderingFailedException
     */
    public function render(string $text, array $data): string;
}
