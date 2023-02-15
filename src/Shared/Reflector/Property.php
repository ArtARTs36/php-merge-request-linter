<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflector;

/**
 * @codeCoverageIgnore
 */
class Property
{
    public function __construct(
        public readonly string $name,
        public readonly Type   $type,
    ) {
        //
    }
}
