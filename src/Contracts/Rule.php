<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Exception\MrLinterException;
use ArtARTs36\MergeRequestLinter\Exception\StopLintException;
use ArtARTs36\MergeRequestLinter\Linter\LintError;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

interface Rule
{
    /**
     * @throws MrLinterException
     * @throws StopLintException
     * @return array<LintError>
     */
    public function lint(MergeRequest $request): array;
}
