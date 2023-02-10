<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionOperator;

/**
 * Interface for resolving Condition Operator.
 * @phpstan-type MergeRequestField value-of<\ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest::FIELDS>
 * @phpstan-type EvaluatorName string
 * @phpstan-type ConditionValue mixed
 * @phpstan-type Condition array<EvaluatorName, ConditionValue>
 */
interface OperatorResolver
{
    /**
     * Resolve Condition Operators.
     * @param array<MergeRequestField, Condition> $when
     */
    public function resolve(array $when): ConditionOperator;
}
