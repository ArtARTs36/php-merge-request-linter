<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDecorator;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Counter;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\NullCounter;

class ConditionRule extends OneRuleDecoratorRule
{
    public function __construct(
        Rule $rule,
        private ConditionOperator $operator,
        private readonly Counter $skippedRules = new NullCounter(),
    ) {
        parent::__construct($rule);
    }

    public function lint(MergeRequest $request): array
    {
        if (! $this->operator->check($request)) {
            $this->skippedRules->inc();

            return [];
        }

        return $this->rule->lint($request);
    }
}
