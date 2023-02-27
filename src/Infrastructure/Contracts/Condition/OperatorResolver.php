<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionOperator;

/**
 * Interface for resolving Condition Operator.
 * @phpstan-type Field string
 * @phpstan-type EvaluatorName string
 * @phpstan-type ConditionValue mixed
 * @phpstan-type Condition array<EvaluatorName, ConditionValue>
 * @phpstan-type Conditions array<Field, Condition>
 */
interface OperatorResolver
{
    /**
     * Resolve Condition Operators.
     * @param Conditions $when
     */
    public function resolve(array $when): ConditionOperator;
}
