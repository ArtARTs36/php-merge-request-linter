<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Condition;

/**
 * Interface for Condition Operator
 */
interface ConditionOperator
{
    /**
     * Check conditions on subject.
     * @throws EvaluatingSubjectException
     */
    public function check(object $subject): bool;
}
