<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Exception\ComparedIncompatibilityTypesException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyNotExists;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

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
    public function evaluate(MergeRequest $request): bool;
}
