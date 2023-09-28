<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ConditionRule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\OperatorResolver;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\CounterVector;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\CollectorRegisterer;

/**
 * @phpstan-import-type Conditions from OperatorResolver
 */
class ConditionRuleFactory
{
    public function __construct(
        private readonly OperatorResolver $operatorResolver,
        private readonly CounterVector $skippedRulesCounter,
    ) {
    }

    public static function new(OperatorResolver $operatorResolver, CollectorRegisterer $metrics): self
    {
        $counter = new CounterVector(new MetricSubject(
            'linter',
            'skipped_rules',
            'Skipped rules',
        ));

        $metrics->register($counter);

        return new self($operatorResolver, $counter);
    }

    /**
     * @param Conditions $when
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
