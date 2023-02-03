<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Rule;

/**
 * Rule Decorator.
 */
interface RuleDecorator extends Rule
{
    /**
     * Get decorated rules.
     * @return array<Rule>
     */
    public function getDecoratedRules(): array;
}
