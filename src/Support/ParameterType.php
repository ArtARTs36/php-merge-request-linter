<?php

namespace ArtARTs36\MergeRequestLinter\Support;

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
}