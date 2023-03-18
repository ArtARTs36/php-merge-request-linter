<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

/**
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
