<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory;

use ArtARTs36\MergeRequestLinter\Condition\OperatorResolver;
use ArtARTs36\MergeRequestLinter\Condition\Operator\CompositeOperator;
use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Exception\RuleNotFound;
use ArtARTs36\MergeRequestLinter\Rule\ConditionableRule;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;

class Resolver
{
    /**
     * @param Map<string, class-string<Rule>> $nameClassRules
     */
    public function __construct(
        private Map $nameClassRules,
        private RuleFactory $factory,
        private OperatorResolver $operatorResolver,
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

        return new ConditionableRule($rule, new CompositeOperator($this->operatorResolver->resolve($params['when'])));
    }
}
