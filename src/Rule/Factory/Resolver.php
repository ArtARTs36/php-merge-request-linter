<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory;

use ArtARTs36\MergeRequestLinter\Condition\Operator\CompositeOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\OperatorResolver;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Exception\RuleNotFound;
use ArtARTs36\MergeRequestLinter\Rule\ConditionRule;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;

class Resolver
{
    /**
     * @param ArrayMap<string, class-string<Rule>> $nameClassRules
     */
    public function __construct(
        private ArrayMap         $nameClassRules,
        private RuleFactory      $factory,
        private ConditionRuleFactory $conditionRuleFactory,
    ) {
        //
    }

    /**
     * @param array<string, mixed> $params
     * @throws RuleNotFound
     */
    public function resolve(string $ruleName, array $params): Rule
    {
        $ruleClass = $this->nameClassRules->get($ruleName);

        if ($ruleClass === null) {
            throw RuleNotFound::fromRuleName($ruleName);
        }

        $rule = $this->factory->create($ruleClass, $params);

        if (! isset($params['when'])) {
            return $rule;
        }

        return $this->conditionRuleFactory->create($rule, $params['when']);
    }
}
