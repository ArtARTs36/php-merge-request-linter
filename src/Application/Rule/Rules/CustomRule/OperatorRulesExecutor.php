<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\CustomRule;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\OperatorResolver;

class OperatorRulesExecutor implements RulesExecutor
{
    public function __construct(
        private readonly OperatorResolver $operator,
    ) {
    }

    public function execute(array $rules, MergeRequest $request): bool
    {
        return $this->operator->resolve($rules)->check($request);
    }
}
