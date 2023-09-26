<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\CompositeRule;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\NonCriticalRule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Rule\RuleResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\CreatingRuleException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\RuleNotFound;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories\ConditionRuleFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Factories\RuleFactory;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;

final class Resolver implements RuleResolver
{
    /**
     * @param Map<string, class-string<Rule>> $nameClassRules
     */
    public function __construct(
        private readonly Map         $nameClassRules,
        private readonly RuleFactory      $factory,
        private readonly ConditionRuleFactory $conditionRuleFactory,
    ) {
    }

    public function resolve(string $ruleName, array $params): Rule
    {
        $ruleClass = $this->nameClassRules->get($ruleName);

        if ($ruleClass === null) {
            throw RuleNotFound::fromRuleName($ruleName);
        }

        if (array_is_list($params) && count($params) !== 0) {
            return $this->resolveRuleOnManyConfigurations($ruleName, $ruleClass, $params);
        }

        /** @var array<string, mixed> $params */
        return $this->resolveRule($ruleName, $ruleClass, $params);
    }

    /**
     * @param class-string<Rule> $ruleClass
     * @param array<int, array<string, mixed>> $params
     * @throws CreatingRuleException
     */
    private function resolveRuleOnManyConfigurations(string $ruleName, string $ruleClass, array $params): Rule
    {
        $rules = [];

        foreach ($params as $param) {
            $rules[] = $this->resolveRule($ruleName, $ruleClass, $param);
        }

        return CompositeRule::make($rules);
    }

    /**
     * @param class-string<Rule> $ruleClass
     * @param array<string, mixed> $params
     * @throws CreatingRuleException
     */
    private function resolveRule(string $ruleName, string $ruleClass, array $params): Rule
    {
        try {
            $rule = $this->factory->create($ruleClass, $params);
        } catch (\Throwable $e) {
            throw new CreatingRuleException(sprintf(
                'Failed to create Rule with name "%s": %s',
                $ruleName,
                $e->getMessage(),
            ));
        }

        if (isset($params['critical'])) {
            if (! is_bool($params['critical'])) {
                throw new ConfigInvalidException(sprintf(
                    'Failed to create Rule with name "%s": param "critical" must be boolean',
                    $ruleName,
                ));
            }

            if ($params['critical'] === false) {
                $rule = new NonCriticalRule($rule);
            }
        }

        if (! isset($params['when'])) {
            return $rule;
        }

        if (! is_array($params['when'])) {
            throw ConfigInvalidException::invalidType(
                'rules.' . $ruleName . '.when',
                'array',
                gettype($params['when']),
            );
        }

        return $this->conditionRuleFactory->create($rule, $params['when']);
    }
}
