<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\DefaultValue;
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
        private ?\Closure $virtualDefaultValuesGetter = null,
    ) {
    }

    public function isRequired(): bool
    {
        return ! $this->type->nullable && ! $this->hasDefaultValue;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getDefaultValue(): mixed
    {
        try {
            return $this->defaultValueGetter === null ? null : ($this->defaultValueGetter)();
        } catch (\ReflectionException $e) {
            throw new \Exception(
                sprintf(
                    'Failed to retrieve parameter "%s" with type "%s" %s',
                    $this->name,
                    $this->type->name->value,
                    $e->getMessage(),
                ),
                previous: $e,
            );
        }
    }

    public function getVirtualDefaultValues(): array
    {
        return array_map(fn (DefaultValue $value) => $value->value, ($this->virtualDefaultValuesGetter)());
    }

    public function hasExamples(): bool
    {
        return count($this->examples) > 0;
    }
}
