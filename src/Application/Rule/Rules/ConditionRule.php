<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\CounterVector;

class ConditionRule extends OneRuleDecoratorRule
{
    public function __construct(
        Rule $rule,
        private readonly ConditionOperator $operator,
        private readonly CounterVector $skippedRules,
    ) {
        parent::__construct($rule);
    }

    public function lint(MergeRequest $request): array
    {
        if (! $this->operator->check($request)) {
            $this
                ->skippedRules
                ->add([
                    'rule' => $this->getName(),
                ])
                ->inc();

            return [];
        }

        return $this->rule->lint($request);
    }
}
