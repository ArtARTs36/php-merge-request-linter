<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Condition;

use ArtARTs36\MergeRequestLinter\Exception\ComparedIncompatibilityTypesException;
use ArtARTs36\MergeRequestLinter\Exception\InvalidEvaluatorValueException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyNotExists;

/**
 * Interface for Condition Operator
 */
interface ConditionEvaluator
{
    /**
     * Evaluate.
     * @throws ComparedIncompatibilityTypesException
     * @throws PropertyNotExists
     * @throws InvalidEvaluatorValueException
     */
    public function evaluate(EvaluatingSubject $subject): bool;
}
