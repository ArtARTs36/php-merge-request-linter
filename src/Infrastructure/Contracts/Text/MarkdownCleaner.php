<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text;

use ArtARTs36\Str\Str;

/**
 * Interface for cleaning markdown.
 */
interface MarkdownCleaner
{
    /**
     * Convert markdown to text.
     */
    public function clean(Str $str): Str;
}
