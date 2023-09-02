<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Rule;

use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\CreatingRuleException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\RuleNotFound;

/**
 * Interface for resolving Rules.
 */
interface RuleResolver
{
    /**
     * Resolve Rule.
     * @param array<mixed> $params
     * @throws RuleNotFound
     * @throws CreatingRuleException
     */
    public function resolve(string $ruleName, array $params): Rule;
}
