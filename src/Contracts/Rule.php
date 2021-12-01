<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Exception\LintException;
use ArtARTs36\MergeRequestLinter\Exception\StopLintException;
use ArtARTs36\MergeRequestLinter\Linter\LintError;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

interface Rule
{
    /**
     * @return array<LintError>
     *@throws StopLintException
     * @throws LintException
     */
    public function lint(MergeRequest $request): array;
}
