<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Attribute\EvaluatesCollectionType;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Collection;

#[Description('Check if an array contains some value.')]
#[EvaluatesCollectionType]
final class HasEvaluator extends ScalarEvaluator
{
    public const NAME = 'has';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject
            ->interface(Collection::class)
            ->contains($this->value);
    }
}
