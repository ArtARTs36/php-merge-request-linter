<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

readonly class RulesMetadata
{
    /**
     * @param array<RuleMetadata> $rules
     */
    public function __construct(
        public array $rules,
    ) {
    }
}
