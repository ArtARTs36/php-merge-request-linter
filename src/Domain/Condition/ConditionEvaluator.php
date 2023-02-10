<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Condition;

use ArtARTs36\MergeRequestLinter\Application\Condition\Exceptions\ComparedIncompatibilityTypesException;
use ArtARTs36\MergeRequestLinter\Application\Condition\Exceptions\InvalidEvaluatorValueException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\PropertyNotExists;

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
