<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector;

/**
 * @codeCoverageIgnore
 */
class Property
{
    public function __construct(
        public readonly string $name,
        public readonly Type   $type,
        public readonly string $description,
    ) {
        //
    }
}
