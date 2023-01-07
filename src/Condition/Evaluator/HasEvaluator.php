<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Condition\Attribute\EvaluatesGenericType;
use ArtARTs36\MergeRequestLinter\Contracts\Condition\EvaluatingSubject;

/**
 * Check if an array contains some value.
 */
#[EvaluatesGenericType]
class HasEvaluator extends ScalarEvaluator
{
    public const NAME = 'has';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject
            ->collection()
            ->contains($this->value);
    }
}
