<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Exception\RuleNotFound;
use ArtARTs36\MergeRequestLinter\Rule\Condition\CompositeOperator;
use ArtARTs36\MergeRequestLinter\Rule\Condition\DefaultOperators;
use ArtARTs36\MergeRequestLinter\Rule\Condition\OperatorFactory;
use ArtARTs36\MergeRequestLinter\Rule\Condition\PropertyExtractor;
use ArtARTs36\MergeRequestLinter\Rule\ConditionableRule;
use ArtARTs36\MergeRequestLinter\Support\Map;

class Resolver
{
    /**
     * @param Map<string, class-string<Rule>> $nameClassRules
     */
    public function __construct(
        private Map $nameClassRules,
        private RuleFactory $factory,
        private OperatorFactory $operatorFactory,
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

        return new ConditionableRule($rule, new CompositeOperator($this->resolveConditionOperators($params['when'])));
    }

    /**
     * @param array<string, array<string, scalar>|scalar> $when
     * @return iterable<ConditionOperator>
     */
    private function resolveConditionOperators(array $when): iterable
    {
        $operators = [];

        foreach ($when as $field => $op) {
            if (is_scalar($op)) {
                $operators[] = $this->operatorFactory->createEqualsOperator($field, $op);

                continue;
            }

            foreach ($op as $operatorType => $value) {
                $operators[] = $this->operatorFactory->create($operatorType, $field, $value);
            }
        }

        return $operators;
    }
}
