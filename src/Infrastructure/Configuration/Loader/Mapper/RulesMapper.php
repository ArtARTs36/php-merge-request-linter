<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper;

use ArtARTs36\MergeRequestLinter\Domain\Rule\Rules as RuleCollection;
use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Resolver;

class RulesMapper
{
    public function __construct(
        private readonly Resolver $ruleResolver,
    ) {
        //
    }

    /**
     * @param array<string, mixed> $rulesData
     */
    public function map(array $rulesData): RuleCollection
    {
        $rules = new RuleCollection([]);

        foreach ($rulesData as $ruleName => $ruleParams) {
            $rules->add($this->ruleResolver->resolve($ruleName, is_array($ruleParams) ? $ruleParams : []));
        }

        return $rules;
    }
}
