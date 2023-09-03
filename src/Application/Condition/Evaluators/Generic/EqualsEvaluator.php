<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Generic;

use ArtARTs36\MergeRequestLinter\Application\Condition\Attribute\EvaluatesSameType;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\ScalarEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;

#[Description('Check if value are equal.')]
#[EvaluatesSameType]
final class EqualsEvaluator extends ScalarEvaluator
{
    public const NAME = 'equals';
    public const SYMBOL = '=';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->scalar() === $this->value;
    }
}
