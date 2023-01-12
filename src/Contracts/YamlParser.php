<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

/**
 * Interface for parsing YAML.
 */
interface YamlParser
{
    /**
     * Parse yaml string to PHP array.
     * @return array<string>
     */
    public function parse(string $yaml): array;
}
