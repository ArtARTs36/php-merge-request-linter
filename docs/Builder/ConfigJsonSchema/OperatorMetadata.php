<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

class OperatorMetadata
{
    /**
     * @param array<string> $names
     * @param array<Parameter> $parameters
     */
    public function __construct(
        public readonly array  $names,
        public readonly string $class,
        public readonly bool   $evaluatesSameType,
        public readonly bool   $evaluatesGenericType,
        public readonly array  $parameters,
        public readonly string $description,
    ) {
        //
    }
}
