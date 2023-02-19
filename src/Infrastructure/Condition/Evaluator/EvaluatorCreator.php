<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;

/**
 * Interface for creating ConditionEvaluator.
 * @phpstan-type EvaluatorName string
 */
interface EvaluatorCreator
{
    /**
     * Create specific condition evaluator.
     * @param EvaluatorName $type
     */
    public function create(string $type, mixed $value): ?ConditionEvaluator;
}
