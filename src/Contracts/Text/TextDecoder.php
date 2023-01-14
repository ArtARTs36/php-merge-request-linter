<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Text;

use ArtARTs36\MergeRequestLinter\Exception\TextDecodingException;

/**
 * Interface for decoding text.
 */
interface TextDecoder
{
    /**
     * Decode string to PHP array.
     * @return array<mixed>
     * @throws TextDecodingException
     */
    public function decode(string $content): array;
}
