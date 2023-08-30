<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

/**
 * @codeCoverageIgnore
 */
readonly class RuleFatalEndedEvent
{
    public function __construct(
        public string $ruleName,
    ) {
        //
    }
}
