<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Request;

use ArtARTs36\Str\Str;

/**
 * @codeCoverageIgnore
 */
readonly class Author
{
    public function __construct(
        public Str $login,
    ) {
    }
}
