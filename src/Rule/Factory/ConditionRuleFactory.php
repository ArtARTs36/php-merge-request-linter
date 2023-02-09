<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory;

use ArtARTs36\MergeRequestLinter\Contracts\Condition\OperatorResolver;
use ArtARTs36\MergeRequestLinter\Contracts\Report\Counter;
use ArtARTs36\MergeRequestLinter\Contracts\Report\MetricManager;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Report\Metrics\MetricSubject;
use ArtARTs36\MergeRequestLinter\Report\Metrics\Value\MemoryCounter;
use ArtARTs36\MergeRequestLinter\Rule\ConditionRule;

/**
 * @phpstan-import-type MergeRequestField from OperatorResolver
 * @phpstan-import-type EvaluatorName from OperatorResolver
 * @phpstan-import-type ConditionValue from OperatorResolver
 * @phpstan-import-type Condition from OperatorResolver
 */
class ConditionRuleFactory
{
    public function __construct(
        private readonly OperatorResolver $operatorResolver,
        private readonly Counter $skippedRulesCounter,
    ) {
        //
    }

    public static function new(OperatorResolver $operatorResolver, MetricManager $metrics): self
    {
        $counter = new MemoryCounter();

        $metrics->add(new MetricSubject('linter_skipped_rules', '[Linter] Skipped rules'), $counter);

        return new self($operatorResolver, $counter);
    }

    /**
     * @param array<MergeRequestField, Condition> $when
     */
    public function create(Rule $rule, array $when): Rule
    {
        return new ConditionRule(
            $rule,
            $this->operatorResolver->resolve($when),
            $this->skippedRulesCounter,
        );
    }
}
