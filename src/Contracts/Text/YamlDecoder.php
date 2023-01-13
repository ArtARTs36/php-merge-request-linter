<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Text;

use ArtARTs36\MergeRequestLinter\Exception\TextDecodingException;

/**
 * Interface for parsing YAML.
 */
interface YamlDecoder
{
    /**
     * Parse yaml string to PHP array.
     * @return array<string>
     * @throws TextDecodingException
     */
    public function decode(string $content): array;
}
