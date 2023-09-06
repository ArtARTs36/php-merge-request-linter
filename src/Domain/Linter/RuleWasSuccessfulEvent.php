<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;

/**
 * @codeCoverageIgnore
 */
#[Description('The event is created at the moment when the linter rule was successful.')]
readonly class RuleWasSuccessfulEvent
{
    public const NAME = 'rule_was_successful';

    public function __construct(
        public string $ruleName,
    ) {
    }
}
