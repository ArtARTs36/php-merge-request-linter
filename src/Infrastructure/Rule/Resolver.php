<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\CompositeRule;
use ArtARTs36\MergeRequestLinter\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Exception\RuleNotFound;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Rule\RuleResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories\ConditionRuleFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories\RuleFactory;

class Resolver implements RuleResolver
{
    /**
     * @param Map<string, class-string<Rule>> $nameClassRules
     */
    public function __construct(
        private readonly Map         $nameClassRules,
        private readonly RuleFactory      $factory,
        private readonly ConditionRuleFactory $conditionRuleFactory,
    ) {
        //
    }

    /**
     * @param array<string, mixed>|array<int, array<string, mixed>> $params
     * @throws RuleNotFound
     */
    public function resolve(string $ruleName, array $params): Rule
    {
        $ruleClass = $this->nameClassRules->get($ruleName);

        if ($ruleClass === null) {
            throw RuleNotFound::fromRuleName($ruleName);
        }

        if (array_is_list($params) && count($params) !== 0) {
            return $this->resolveRuleOnManyConfigurations($ruleClass, $params);
        }

        /** @var array<string, mixed> $params */
        return $this->resolveRule($ruleClass, $params);
    }

    /**
     * @param class-string<Rule> $ruleClass
     * @param array<int, array<string, mixed>> $params
     */
    private function resolveRuleOnManyConfigurations(string $ruleClass, array $params): Rule
    {
        $rules = [];

        foreach ($params as $param) {
            $rules[] = $this->resolveRule($ruleClass, $param);
        }

        return CompositeRule::make($rules);
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
