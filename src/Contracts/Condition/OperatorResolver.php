<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Condition;

/**
 * Interface for resolving Condition Operator.
 */
interface OperatorResolver
{
    /**
     * Resolve Condition Operators.
     * @param array<string, array<string, scalar>> $when
     */
    public function resolve(array $when): ConditionOperator;
}
