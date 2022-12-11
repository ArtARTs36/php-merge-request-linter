<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Exception\LintException;
use ArtARTs36\MergeRequestLinter\Exception\StopLintException;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

/**
 * Rule for lint "merge request".
 */
interface Rule
{
    /**
     * Get rule name.
     */
    public function getName(): string;

    /**
     * Lint "merge request" by specific rules.
     * Returns empty array if notes are not found.
     * @return array<Note>
     * @throws StopLintException
     * @throws LintException
     */
    public function lint(MergeRequest $request): array;

    /**
     * Get rule definition.
     */
    public function getDefinition(): RuleDefinition;
}
