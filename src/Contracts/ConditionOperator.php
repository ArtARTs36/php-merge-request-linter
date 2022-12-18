<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Exception\ComparedIncompatibilityTypesException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyNotExists;

/**
 * Interface for Condition Operator
 */
interface ConditionOperator
{
    /**
     * Evaluate.
     * @throws ComparedIncompatibilityTypesException
     * @throws PropertyNotExists
     */
    public function evaluate(object $subject): bool;
}
