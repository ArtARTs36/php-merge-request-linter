<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Attribute\EvaluatesSameType;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Number;

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
        return $subject->interface(Number::class)->lte($this->value);
    }
}
