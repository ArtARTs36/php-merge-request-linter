<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

class RuleWasFailedEvent
{
    public function __construct(
        public readonly string $ruleName,
    ) {
        //
    }
}
