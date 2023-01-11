<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Contracts\Condition\EvaluatingSubject;

/**
 * Check count not equals.
 */
class CountNotEqualsEvaluator extends IntEvaluator
{
    public const NAME = 'countNotEquals';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->collection()->count() !== $this->value;
    }
}
