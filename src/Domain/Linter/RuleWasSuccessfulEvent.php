<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

/**
 * @codeCoverageIgnore
 */
class RuleWasSuccessfulEvent
{
    public function __construct(
        public readonly string $ruleName,
    ) {
        //
    }
}
