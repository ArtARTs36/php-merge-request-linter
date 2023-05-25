<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

/**
 * The event is created at the moment when the linter rule was successful.
 * @codeCoverageIgnore
 */
class RuleWasSuccessfulEvent
{
    public const NAME = 'rule_was_successful';

    public function __construct(
        public readonly string $ruleName,
    ) {
        //
    }
}
