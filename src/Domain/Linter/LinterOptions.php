<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

/**
 * @codeCoverageIgnore
 */
readonly class LinterOptions
{
    public function __construct(
        public bool $stopOnFailure = false,
        public bool $stopOnWarning = false,
    ) {
    }
}
