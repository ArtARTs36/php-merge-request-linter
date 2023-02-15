<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Attribute\EvaluatesCollectionType;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

/**
 * Check if an array contains some value.
 */
#[EvaluatesCollectionType]
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
