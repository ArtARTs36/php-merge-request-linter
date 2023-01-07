<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader;

use ArtARTs36\MergeRequestLinter\Rule\Factory\Resolver;
use ArtARTs36\MergeRequestLinter\Rule\Rules;

class RulesMapper
{
    public function __construct(
        private Resolver $ruleResolver,
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
