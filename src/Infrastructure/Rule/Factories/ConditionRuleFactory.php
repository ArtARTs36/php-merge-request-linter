<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ConditionRule;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\Counter;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\MemoryCounter;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\MetricManager;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\MetricSubject;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\OperatorResolver;

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
