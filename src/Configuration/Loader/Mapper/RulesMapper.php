<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader\Mapper;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\Rules;
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
    public function map(array $rulesData): Rules
    {
        $rules = new Rules([]);

        foreach ($rulesData as $ruleName => $ruleParams) {
            $rules->add($this->ruleResolver->resolve($ruleName, is_array($ruleParams) ? $ruleParams : []));
        }

        return $rules;
    }
}
