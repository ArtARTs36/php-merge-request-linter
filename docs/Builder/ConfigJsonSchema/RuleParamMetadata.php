<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Example;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;

readonly class RuleParamMetadata
{
    /**
     * @param array<Example> $examples
     * @param array<string|int> $enum
     * @param array<RuleParamMetadata> $nestedObjectParams
     * @param array<RuleParamMetadata> $genericObjectParams
     * @param array<mixed> $virtualDefaultValues
     */
    public function __construct(
        public string             $name,
        public string             $description,
        public bool               $required,
        public array              $examples,
        public Type               $type,
        public ?string            $jsonType,
        public array              $enum,
        public array $nestedObjectParams,
        public array $genericObjectParams,
        public mixed $defaultValue,
        public bool $hasDefaultValue,
        public array $virtualDefaultValues,
    ) {
    }
}
