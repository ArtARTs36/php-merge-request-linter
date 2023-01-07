<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Contracts\Condition\ConditionOperator;

class CompositeOperator implements ConditionOperator
{
    /**
     * @param iterable<ConditionOperator> $operators
     */
    public function __construct(
        private readonly iterable $operators,
    ) {
        //
    }

    public function check(object $subject): bool
    {
        foreach ($this->operators as $operator) {
            if (! $operator->check($subject)) {
                return false;
            }
        }

        return true;
    }
}
