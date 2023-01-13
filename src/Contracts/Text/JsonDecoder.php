<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Text;

use ArtARTs36\MergeRequestLinter\Exception\TextDecodingException;

/**
 * Interface for decoding JSON.
 */
interface JsonDecoder
{
    /**
     * Decode JSON string to PHP array.
     * @return array<mixed>
     * @throws TextDecodingException
     */
    public function decode(string $content): array;
}
