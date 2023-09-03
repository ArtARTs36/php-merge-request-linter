<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

readonly class RuleMetadata
{
    /**
     * @param array<RuleParamMetadata> $params
     */
    public function __construct(
        public string $name,
        public string $class,
        public string $description,
        public array $params,
    ) {
    }
}
