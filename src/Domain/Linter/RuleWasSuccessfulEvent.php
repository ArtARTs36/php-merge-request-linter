<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

class RuleWasSuccessfulEvent
{
    public function __construct(
        public readonly string $ruleName,
    ) {
        //
    }
}
