<?php

namespace ArtARTs36\MergeRequestLinter\Application\Linter\Tasks;

/**
 * @codeCoverageIgnore
 */
class LintTask
{
    public function __construct(
        public readonly string $workingDirectory,
        public readonly ?string $customPath,
    ) {
        //
    }
}
