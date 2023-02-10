<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Condition;

use ArtARTs36\MergeRequestLinter\Exception\ComparedIncompatibilityTypesException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyNotExists;

/**
 * Interface for Condition Operator
 */
interface ConditionOperator
{
    /**
     * Check conditions on subject.
     * @throws ComparedIncompatibilityTypesException
     * @throws PropertyNotExists
     */
    public function check(object $subject): bool;
}
