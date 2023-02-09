<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Condition\Attribute\EvaluatesGenericType;
use ArtARTs36\MergeRequestLinter\Contracts\Condition\EvaluatingSubject;

/**
 * Check if an array not contains some value.
 */
#[EvaluatesGenericType]
class NotHasEvaluator extends ScalarEvaluator
{
    public const NAME = 'notHas';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return ! $subject->collection()->contains($this->value);
    }
}
