<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

class CompositeOperator implements ConditionOperator
{
    /**
     * @param iterable<ConditionOperator> $operators
     */
    public function __construct(private iterable $operators)
    {
        //
    }

    public function evaluate(object $subject): bool
    {
        foreach ($this->operators as $operator) {
            if (! $operator->evaluate($subject)) {
                return false;
            }
        }

        return true;
    }
}
