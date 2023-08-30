<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Rule;

use ArtARTs36\MergeRequestLinter\Domain\Note\Note;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * Rule for lint "merge request".
 */
interface Rule
{
    /**
     * Get rule name.
     *
     * @return non-empty-string
     */
    public function getName(): string;

    /**
     * Lint "merge request" by specific rules.
     * Returns empty array if notes are not found.
     * @return array<Note>
     */
    public function lint(MergeRequest $request): array;

    /**
     * Get rule definition.
     */
    public function getDefinition(): RuleDefinition;
}
