<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

use ArtARTs36\MergeRequestLinter\Application\Linter\Linter;

/**
 * Linter Runner
 */
interface LinterRunner
{
    /**
     * Run Linter
     */
    public function run(Linter $linter): LintResult;
}
