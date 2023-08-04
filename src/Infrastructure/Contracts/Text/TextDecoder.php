<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text;

/**
 * Interface for text decoding.
 */
interface TextDecoder
{
    /**
     * Decode string to PHP array.
     * @return array<mixed>
     * @throws DecodingFailedException
     */
    public function decode(string $content): array;
}
