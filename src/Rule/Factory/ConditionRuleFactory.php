<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory;

use ArtARTs36\MergeRequestLinter\Condition\Operator\CompositeOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\OperatorResolver;
use ArtARTs36\MergeRequestLinter\Contracts\Report\MetricManager;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Report\Metrics\MetricSubject;
use ArtARTs36\MergeRequestLinter\Report\Metrics\Value\Counter;
use ArtARTs36\MergeRequestLinter\Rule\ConditionRule;

class ConditionRuleFactory
{
    public function __construct(
        private OperatorResolver $operatorResolver,
        private \ArtARTs36\MergeRequestLinter\Contracts\Report\Counter $skippedRulesCounter,
    ) {
        //
    }

    public static function new(OperatorResolver $operatorResolver, MetricManager $metrics): self
    {
        $counter = new Counter();

        $metrics->add(new MetricSubject('linter_skipped_rules', '[Linter] Skipped rules'), $counter);

        return new self($operatorResolver, $counter);
    }

    public function create(Rule $rule, array $when): Rule
    {
        return new ConditionRule(
            $rule,
            new CompositeOperator($this->operatorResolver->resolve($when)),
            $this->skippedRulesCounter,
        );
    }
}
