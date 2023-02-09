<?php

namespace ArtARTs36\MergeRequestLinter\Support\Reflector;

class ParameterType
{
    /**
     * @param class-string|null $class
     * @param string|class-string|null $generic
     */
    public function __construct(
        public readonly ParameterTypeName $name,
        public readonly ?string $class = null,
        public readonly ?string $generic = null,
    ) {
        //
    }

    public function isGeneric(): bool
    {
        return $this->generic !== null;
    }

    public function isGenericOfObject(): bool
    {
        return $this->generic !== null && class_exists($this->generic);
    }
}
