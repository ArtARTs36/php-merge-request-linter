<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class CompositeOperator implements ConditionOperator
{
    /**
     * @param iterable<ConditionOperator> $operators
     */
    public function __construct(private iterable $operators)
    {
        //
    }

    public function evaluate(MergeRequest $request): bool
    {
        foreach ($this->operators as $operator) {
            if (! $operator->evaluate($request)) {
                return false;
            }
        }

        return true;
    }
}
