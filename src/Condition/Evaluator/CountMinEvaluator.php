<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Contracts\EvaluatingSubject;

/**
 * Check the minimum number of elements in a field.
 */
class CountMinEvaluator extends IntEvaluator
{
    public const NAME = 'countMin';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return count($subject->collection()) >= $this->value;
    }
}
