<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Condition\Attribute\EvaluatesSameType;
use ArtARTs36\MergeRequestLinter\Contracts\Condition\EvaluatingSubject;

/**
 * Check number is equal to or less than.
 */
#[EvaluatesSameType]
class LteEvaluator extends NumberEvaluator
{
    public const NAME = 'lte';
    public const SYMBOL = '<=';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->numeric() <= $this->value;
    }
}
