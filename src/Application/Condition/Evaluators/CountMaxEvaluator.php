<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

/**
 * Check the maximum number of elements in a field.
 */
class CountMaxEvaluator extends IntEvaluator
{
    public const NAME = 'countMax';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->collection()->count() <= $this->value;
    }
}
