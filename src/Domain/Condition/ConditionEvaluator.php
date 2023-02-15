<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Condition;

/**
 * Interface for Condition Operator
 */
interface ConditionEvaluator
{
    /**
     * Evaluate.
     * @throws EvaluatingSubjectException
     */
    public function evaluate(EvaluatingSubject $subject): bool;
}
