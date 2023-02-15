<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text;

/**
 * Interface for decoding text.
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
