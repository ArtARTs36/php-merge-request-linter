<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector;

readonly class Type
{
    /**
     * @param class-string|null $class
     * @param string|class-string|null $generic
     */
    public function __construct(
        public TypeName $name,
        public ?string  $class = null,
        public ?string  $generic = null,
        public bool     $nullable = false,
    ) {
        //
    }

    public function name(): string
    {
        return $this->class ?? $this->name->value;
    }

    public function isGeneric(): bool
    {
        return $this->generic !== null;
    }

    /**
     * @return class-string|null
     */
    public function getObjectGeneric(): ?string
    {
        return $this->generic !== null && (class_exists($this->generic) || interface_exists($this->generic)) ?
            $this->generic :
            null;
    }

    public function isClass(): bool
    {
        return $this->class !== null && class_exists($this->class);
    }
}
