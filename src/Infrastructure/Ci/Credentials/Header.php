<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials;

/**
 * @codeCoverageIgnore
 */
readonly class Header
{
    public function __construct(
        public string $name,
        public string $value,
    ) {
    }
}
