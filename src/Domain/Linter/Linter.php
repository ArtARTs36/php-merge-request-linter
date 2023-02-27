<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * Interface for Linter.
 */
interface Linter
{
    /**
     * Lint merge request.
     */
    public function run(MergeRequest $request): LintResult;
}
