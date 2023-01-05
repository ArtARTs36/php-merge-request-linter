<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Condition\Attribute\EvaluatesSameType;
use ArtARTs36\MergeRequestLinter\Contracts\Condition\EvaluatingSubject;

/**
 * Check if value are not equal.
 */
#[EvaluatesSameType]
class NotEqualsEvaluator extends ScalarEvaluator
{
    public const NAME = 'notEquals';
    public const SYMBOL = '!=';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->scalar() !== $this->value;
    }
}
