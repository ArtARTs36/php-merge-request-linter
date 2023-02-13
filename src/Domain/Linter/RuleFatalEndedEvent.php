<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

/**
 * @codeCoverageIgnore
 */
class RuleFatalEndedEvent
{
    public function __construct(
        public readonly string $ruleName,
    ) {
        //
    }
}
