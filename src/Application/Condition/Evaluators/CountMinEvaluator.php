<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

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
