<?php

namespace ArtARTs36\MergeRequestLinter\Application\Linter\Tasks;

class LintTask
{
    public function __construct(
        public readonly string $workingDirectory,
        public readonly ?string $customPath,
    ) {
        //
    }
}
