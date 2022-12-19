<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Condition\Attribute\EvaluatesSameType;
use ArtARTs36\MergeRequestLinter\Contracts\EvaluatingSubject;

/**
 * Check if value are equal.
 */
#[EvaluatesSameType]
class EqualsEvaluator extends ScalarEvaluator
{
    public const NAME = 'equals';
    public const SYMBOL = '=';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->scalar() === $this->value;
    }
}
