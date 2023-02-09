<?php

namespace ArtARTs36\MergeRequestLinter\Request\Data;

use ArtARTs36\Str\Str;

class Author
{
    public function __construct(
        public readonly Str $login,
    ) {
        //
    }
}
