<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Attribute\EvaluatesSameType;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

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
