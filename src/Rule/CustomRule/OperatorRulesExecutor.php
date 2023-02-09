<?php

namespace ArtARTs36\MergeRequestLinter\Rule\CustomRule;

use ArtARTs36\MergeRequestLinter\Contracts\Condition\OperatorResolver;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

class OperatorRulesExecutor implements RulesExecutor
{
    public function __construct(
        private readonly OperatorResolver $operator,
    ) {
        //
    }

    public function execute(array $rules, MergeRequest $request): bool
    {
        return $this->operator->resolve($rules)->check($request);
    }
}
