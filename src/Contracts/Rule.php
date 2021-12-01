<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Exception\LintException;
use ArtARTs36\MergeRequestLinter\Exception\StopLintException;
use ArtARTs36\MergeRequestLinter\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

interface Rule
{
    /**
     * Lint merge request by specifics rules
     * @return array<LintNote>
     * @throws StopLintException
     * @throws LintException
     */
    public function lint(MergeRequest $request): array;

    /**
     * Get rule definition
     */
    public function getDefinition(): string;
}
