<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Exception\RuleNotFound;

/**
 * Interface for resolving Rules.
 */
interface RuleResolver
{
    /**
     * Resolve Rule.
     * @param array<string, mixed>|array<int, array<string, mixed>> $params
     * @throws RuleNotFound
     */
    public function resolve(string $ruleName, array $params): Rule;
}
