<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Attribute\EvaluatesCollectionType;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Collection;

/**
 * Check if an array not contains some value.
 */
#[EvaluatesCollectionType]
class NotHasEvaluator extends ScalarEvaluator
{
    public const NAME = 'notHas';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return ! $subject->interface(Collection::class)->contains($this->value);
    }
}
