<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Example;

class Parameter
{
    /**
     * @param array<Example> $examples
     */
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly array $examples,
        public readonly Type $type,
        public readonly bool $hasDefaultValue = false,
        private readonly ?\Closure $defaultValueGetter = null,
    ) {
        //
    }

    public function isRequired(): bool
    {
        return ! $this->type->nullable && ! $this->hasDefaultValue;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue(): mixed
    {
        return $this->defaultValueGetter === null ? null : ($this->defaultValueGetter)();
    }
}
