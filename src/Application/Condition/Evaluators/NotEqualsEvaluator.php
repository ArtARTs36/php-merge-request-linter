<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Attribute\EvaluatesSameType;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;

#[Description('Check if value are not equal.')]
#[EvaluatesSameType]
final class NotEqualsEvaluator extends ScalarEvaluator
{
    public const NAME = 'notEquals';
    public const SYMBOL = '!=';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->scalar() !== $this->value;
    }
}
