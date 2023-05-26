<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

/**
 * @codeCoverageIgnore
 */
class LinterOptions
{
    public function __construct(
        public readonly bool $stopOnFailure = false,
        public readonly bool $stopOnWarning = false,
    ) {
        //
    }
}
