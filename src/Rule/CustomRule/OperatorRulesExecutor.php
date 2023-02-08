<?php

namespace ArtARTs36\MergeRequestLinter\Rule\CustomRule;

use ArtARTs36\MergeRequestLinter\Contracts\Condition\OperatorResolver;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

class OperatorRulesExecutor implements RulesExecutor
{
    public function __construct(
        private readonly OperatorResolver $operator,
    ) {
        //
    }

    public function execute(array $rules, MergeRequest $request): bool
    {
        foreach ($rules as $rule) {
            if (! $this->operator->resolve($rule)->check($request)) {
                return false;
            }
        }

        return true;
    }
}
