<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Rule\DefaultRules;
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
     * @param iterable<class-string<Rule>> $ruleClasses
     */
    public static function make(iterable $ruleClasses, RuleFactory $factory): self
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
        $ruleClass = $this->nameClassRules->get($ruleName);

        if ($ruleClass === null) {
            throw new \Exception(sprintf('Rule with %s cant resolved', $ruleName));
        }

        return $this->factory->create($ruleClass, $params);
    }
}
