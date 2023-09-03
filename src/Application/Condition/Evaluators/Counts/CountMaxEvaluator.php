<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\IntEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Collection;

#[Description('Check the maximum number of elements in a field.')]
final class CountMaxEvaluator extends IntEvaluator
{
    public const NAME = 'countMax';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->interface(Collection::class)->count() <= $this->value;
    }
}
