<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text;

/**
 * Interface for TextEncoder.
 */
interface TextEncoder
{
    /**
     * Encode Text
     *
     * @param array<mixed> $data
     */
    public function encode(array $data): string;
}
