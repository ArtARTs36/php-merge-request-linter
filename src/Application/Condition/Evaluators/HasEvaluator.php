<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Attribute\EvaluatesCollectionType;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Collection;

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
            ->interface(Collection::class)
            ->contains($this->value);
    }
}
