<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Contracts\EvaluatingSubject;

/**
 * Check the maximum number of elements in a field.
 */
class CountMaxEvaluator extends IntEvaluator
{
    public const NAME = 'countMax';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return count($subject->collection()) <= $this->value;
    }
}
