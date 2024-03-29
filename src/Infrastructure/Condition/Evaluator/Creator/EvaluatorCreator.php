<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\ConditionEvaluatorNotFound;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\InvalidEvaluatorValueException;

/**
 * Interface for creating ConditionEvaluator.
 * @phpstan-type EvaluatorName string
 */
interface EvaluatorCreator
{
    /**
     * Create specific condition evaluator.
     * @param EvaluatorName $type
     * @throws ConditionEvaluatorNotFound
     * @throws InvalidEvaluatorValueException
     */
    public function create(string $type, mixed $value): ?ConditionEvaluator;
}
