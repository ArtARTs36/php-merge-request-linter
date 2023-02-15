<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

/**
 * @codeCoverageIgnore
 */
class RuleWasFailedEvent
{
    public function __construct(
        public readonly string $ruleName,
    ) {
        //
    }
}
