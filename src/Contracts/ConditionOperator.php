<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

/**
 * Interface for Condition Operator
 */
interface ConditionOperator
{
    /**
     * Evaluate.
     */
    public function evaluate(MergeRequest $request): bool;
}
