<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Exception\RuleNotFound;
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
     * @param array<string, mixed> $params
     * @throws RuleNotFound
     */
    public function resolve(string $ruleName, array $params): Rule
    {
        $ruleClass = $this->nameClassRules->get($ruleName);

        if ($ruleClass === null) {
            throw RuleNotFound::fromRuleName($ruleName);
        }

        return $this->factory->create($ruleClass, $params);
    }
}
