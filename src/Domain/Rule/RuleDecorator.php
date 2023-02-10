<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Rule;

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
