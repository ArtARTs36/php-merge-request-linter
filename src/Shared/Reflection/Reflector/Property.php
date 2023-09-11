<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector;

/**
 * @codeCoverageIgnore
 */
readonly class Property
{
    public function __construct(
        public string $name,
        public Type   $type,
        public string $description,
    ) {
    }
}
