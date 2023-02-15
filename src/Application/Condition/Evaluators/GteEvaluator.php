<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Attribute\EvaluatesSameType;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

/**
 * Check if a number is greater than or less than.
 */
#[EvaluatesSameType]
class GteEvaluator extends NumberEvaluator
{
    public const NAME = 'gte';
    public const SYMBOL = '>=';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->numeric() >= $this->value;
    }
}
