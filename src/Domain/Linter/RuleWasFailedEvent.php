<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

use ArtARTs36\MergeRequestLinter\Domain\Note\Note;

/**
 * @codeCoverageIgnore
 */
class RuleWasFailedEvent
{
    public const NAME = 'rule_was_failed';

    /**
     * @param array<Note> $notes
     */
    public function __construct(
        public readonly string $ruleName,
        public readonly array $notes,
    ) {
        //
    }
}
