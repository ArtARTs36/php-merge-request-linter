<?php

namespace ArtARTs36\MergeRequestLinter\Support\Reflector;

class ParameterType
{
    /**
     * @param string|class-string|null $generic
     */
    public function __construct(
        public readonly string  $name,
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
