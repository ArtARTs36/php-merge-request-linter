<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Exception\LintException;
use ArtARTs36\MergeRequestLinter\Exception\StopLintException;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

/**
 * Rule for lint merge request
 */
interface Rule
{
    /**
     * Lint merge request by specifics rules
     * @return array<Note>
     * @throws StopLintException
     * @throws LintException
     */
    public function lint(MergeRequest $request): array;

    /**
     * Get rule definition
     */
    public function getDefinition(): RuleDefinition;
}
