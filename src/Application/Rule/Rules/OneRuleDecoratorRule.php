<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDecorator;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;

abstract class OneRuleDecoratorRule implements RuleDecorator
{
    public function __construct(
        protected readonly Rule $rule,
    ) {
    }

    public function getName(): string
    {
        return $this->rule->getName();
    }

    public function getDefinition(): RuleDefinition
    {
        return $this->rule->getDefinition();
    }

    public function getDecoratedRules(): array
    {
        return [$this->rule];
    }
}
