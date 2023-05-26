<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\IntEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Collection;

/**
 * Check count equals.
 */
class CountEqualsEvaluator extends IntEvaluator
{
    public const NAME = 'countEquals';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->interface(Collection::class)->count() === $this->value;
    }
}
