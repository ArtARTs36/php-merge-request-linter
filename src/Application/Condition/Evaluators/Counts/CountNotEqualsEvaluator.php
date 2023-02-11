<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\IntEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

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
