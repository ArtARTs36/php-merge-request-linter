<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Example;

readonly class Parameter
{
    /**
     * @param array<Example> $examples
     */
    public function __construct(
        public string     $name,
        public string     $description,
        public array      $examples,
        public Type       $type,
        public bool       $hasDefaultValue = false,
        private ?\Closure $defaultValueGetter = null,
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

    public function hasExamples(): bool
    {
        return count($this->examples) > 0;
    }
}
