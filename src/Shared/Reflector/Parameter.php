<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflector;

class Parameter
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly Type $type,
    ) {
        //
    }
}
