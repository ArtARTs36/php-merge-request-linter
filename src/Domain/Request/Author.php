<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Request;

use ArtARTs36\Str\Str;

/**
 * @codeCoverageIgnore
 */
class Author
{
    public function __construct(
        public readonly Str $login,
    ) {
        //
    }
}
