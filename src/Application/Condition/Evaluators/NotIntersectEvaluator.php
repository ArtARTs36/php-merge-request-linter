<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Collection;

/**
 * @template K of int|string
 * @template V
 */
#[Description('Check that the array does not intersect with the user array.')]
final class NotIntersectEvaluator extends Evaluator
{
    public const NAME = 'notIntersect';

    /**
     * @param non-empty-array<K, V> $value
     */
    public function __construct(
        #[Generic(Generic::OF_STRING)]
        private readonly array $value,
    ) {
    }

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return ! $this->collectionIsIntersectValues(
            $subject->interface(Collection::class),
        );
    }

    /**
     * @param Collection<K, V> $collection
     */
    protected function collectionIsIntersectValues(Collection $collection): bool
    {
        foreach ($this->value as $val) {
            if (! $collection->contains($val)) {
                return false;
            }
        }

        return true;
    }
}
