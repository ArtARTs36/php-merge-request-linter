<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Text;

/**
 * Interface for decoding JSON.
 */
interface JsonDecoder
{
    /**
     * Decode JSON string to PHP array.
     * @return array<mixed>
     * @throws \InvalidArgumentException
     */
    public function decode(string $json): array;
}
