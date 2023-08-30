<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

/**
 * The event is created at the moment when the linter rule was successful.
 * @codeCoverageIgnore
 */
readonly class RuleWasSuccessfulEvent
{
    public const NAME = 'rule_was_successful';

    public function __construct(
        public string $ruleName,
    ) {
        //
    }
}
