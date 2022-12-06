<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Support\Map;

class Resolver
{
    /**
     * @param Map<string, class-string<Rule>> $nameClassRules
     */
    public function __construct(
        private Map $nameClassRules,
        private RuleFactory $factory,
    ) {
        //
    }

    /**
     * @param array<class-string<Rule>> $ruleClasses
     * @return static
     */
    public static function make(array $ruleClasses, RuleFactory $factory): self
    {
        $map = [];

        foreach ($ruleClasses as $class) {
            $map[$class::getName()] = $class;
        }

        return new self(new Map($map), $factory);
    }

    /**
     * @param string $ruleName
     * @param array<string, mixed> $params
     * @throws \Exception
     */
    public function resolve(string $ruleName, array $params): Rule
    {
        if ($this->nameClassRules->missing($ruleName)) {
            throw new \Exception(sprintf('Rule with %s cant resolved', $ruleName));
        }

        return $this->factory->create($this->nameClassRules->get($ruleName), $params);
    }
}
