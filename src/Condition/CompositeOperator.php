<?php

namespace ArtARTs36\MergeRequestLinter\Condition;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Contracts\ConditionEvaluator;

class CompositeOperator implements ConditionOperator
{
    /**
     * @param iterable<ConditionEvaluator> $operators
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
