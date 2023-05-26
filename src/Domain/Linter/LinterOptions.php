<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

class LinterOptions
{
    public function __construct(
        public readonly bool $stopOnFailure,
        public readonly bool $stopOnWarning,
    ) {
        //
    }
}
