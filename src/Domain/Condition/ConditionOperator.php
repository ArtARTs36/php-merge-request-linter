<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Condition;

use ArtARTs36\MergeRequestLinter\Application\Condition\Exceptions\ComparedIncompatibilityTypesException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\PropertyNotExists;

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
