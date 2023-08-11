<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials;

/**
 * @codeCoverageIgnore
 */
class Header
{
    public function __construct(
        public readonly string $name,
        public readonly string $value,
    ) {
    }
}
