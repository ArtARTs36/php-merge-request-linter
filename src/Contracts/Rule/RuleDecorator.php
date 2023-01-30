<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Rule;

/**
 * Rule Decorator.
 */
interface RuleDecorator extends Rule
{
    /**
     * Get decorated rule.
     * @return array<Rule>
     */
    public function getDecoratedRules(): array;
}
