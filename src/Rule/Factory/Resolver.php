<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Exception\RuleNotFound;
use ArtARTs36\MergeRequestLinter\Rule\CompositeRule;
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

        if (array_is_list($params)) {
            $rules = [];

            foreach ($params as $param) {
                $rules[] = $this->resolveRule($ruleClass, $param);
            }

            return new CompositeRule($rules);
        }

        return $this->resolveRule($ruleClass, $params);
    }

    /**
     * @param class-string<Rule> $ruleClass
     * @param array<string, mixed> $params
     */
    private function resolveRule(string $ruleClass, array $params): Rule
    {
        $rule = $this->factory->create($ruleClass, $params);

        if (! isset($params['when'])) {
            return $rule;
        }

        return $this->conditionRuleFactory->create($rule, $params['when']);
    }
}
