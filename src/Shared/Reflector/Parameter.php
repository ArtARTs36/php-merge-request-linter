<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflector;

class Parameter
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly Type $type,
        public readonly bool $hasDefaultValue = false,
    ) {
        //
    }

    public function isRequired(): bool
    {
        return ! $this->type->nullable && ! $this->hasDefaultValue;
    }
}
