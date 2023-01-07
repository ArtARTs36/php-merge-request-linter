<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

class Parameter
{
    public function __construct(
        public readonly string $type,
        public readonly string $jsonType,
        public readonly ?string $generic = null,
    ) {
        //
    }

    public function isGeneric(): bool
    {
        return $this->generic !== null;
    }
}
