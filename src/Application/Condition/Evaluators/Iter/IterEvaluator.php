<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Iter;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;

abstract class IterEvaluator implements ConditionEvaluator
{
    /**
     * @param iterable<ConditionEvaluator> $evaluators
     */
    public function __construct(
        protected readonly iterable $evaluators,
    ) {
        //
    }
}
