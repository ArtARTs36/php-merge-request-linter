<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Linter\Note;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Exception\LintException;
use ArtARTs36\MergeRequestLinter\Exception\StopLintException;

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
