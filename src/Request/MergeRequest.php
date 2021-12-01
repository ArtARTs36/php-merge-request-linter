<?php

namespace ArtARTs36\MergeRequestLinter\Request;

use ArtARTs36\MergeRequestLinter\Support\Map;
use ArtARTs36\Str\Str;

class MergeRequest
{
    public function __construct(
        public Str $title,
        public Str $description,
        public Map $labels,
        public bool $hasConflicts,
    ) {
        //
    }
}
