<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

/**
 * @codeCoverageIgnore
 */
class RuleWasFailedEvent
{
    public const NAME = 'rule_was_failed';

    public function __construct(
        public readonly string $ruleName,
    ) {
        //
    }
}
