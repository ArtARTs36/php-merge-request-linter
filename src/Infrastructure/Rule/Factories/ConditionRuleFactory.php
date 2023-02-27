<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ConditionRule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\OperatorResolver;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Counter;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\IncCounter;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSubject;

/**
 * @phpstan-import-type Conditions from OperatorResolver
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
        $counter = new IncCounter();

        $metrics->add(new MetricSubject('linter_skipped_rules', '[Linter] Skipped rules'), $counter);

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
