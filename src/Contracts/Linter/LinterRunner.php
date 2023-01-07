<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Linter;

use ArtARTs36\MergeRequestLinter\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Linter\LintResult;

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
