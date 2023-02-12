<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

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
