<?php

namespace ArtARTs36\MergeRequestLinter\Linter;

class LintError
{
    public function __construct(
        public string $description,
    ) {
        //
    }
}
