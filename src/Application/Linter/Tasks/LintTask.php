<?php

namespace ArtARTs36\MergeRequestLinter\Application\Linter\Tasks;

/**
 * @codeCoverageIgnore
 */
readonly class LintTask
{
    public function __construct(
        public string  $workingDirectory,
        public ?string $customPath,
    ) {
    }
}
