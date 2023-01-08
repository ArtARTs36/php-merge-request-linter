<?php

namespace ArtARTs36\MergeRequestLinter\Support\Reflector;

class ParameterType
{
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
        return $this->isGeneric() && class_exists($this->generic);
    }
}
