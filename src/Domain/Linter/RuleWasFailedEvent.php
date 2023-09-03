<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

use ArtARTs36\MergeRequestLinter\Domain\Note\Note;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;

/**
 * @codeCoverageIgnore
 */
#[Description('The event is created at the moment when the linter rule was failed.')]
readonly class RuleWasFailedEvent
{
    public const NAME = 'rule_was_failed';

    /**
     * @param array<Note> $notes
     */
    public function __construct(
        public string $ruleName,
        public array  $notes,
    ) {
        //
    }
}
