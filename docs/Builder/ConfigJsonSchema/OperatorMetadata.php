<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

class OperatorMetadata
{
    public function __construct(
        public readonly string $name,
        public readonly string $class,
        public readonly bool $evaluatesSameType,
        public readonly array $allowValueTypes,
    ) {
        //
    }
}
