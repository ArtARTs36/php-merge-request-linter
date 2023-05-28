<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector;

class Parameter
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
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
