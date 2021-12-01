<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Linter\LintError;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

interface Rule
{
    /**
     * @return array<LintError>
     */
    public function lint(MergeRequest $request): array;
}
