<?php

namespace ArtARTs36\MergeRequestLinter\Request;

use ArtARTs36\Str\Str;

class MergeRequest
{
    public function __construct(
        public Str $title,
        public Str $description,
        public Labels $labels,
        public bool $hasConflicts,
    ) {
        //
    }
}
