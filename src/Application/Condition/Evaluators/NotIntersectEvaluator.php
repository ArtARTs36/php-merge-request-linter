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
#[Description('Check if an array contains only one value of list.')]
final class NotIntersectEvaluator extends Evaluator
{
    public const NAME = 'notIntersect';

    /**
     * @param array<K, V> $value
     */
    public function __construct(
        #[Generic(Generic::OF_STRING)]
        private readonly array $value,
    ) {
    }

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return ! $this->collectionContainsDifferentValues(
            $subject->interface(Collection::class),
        );
    }

    /**
     * @param Collection<K, V> $collection
     */
    protected function collectionContainsDifferentValues(Collection $collection): bool
    {
        $matched = 0;

        foreach ($this->value as $val) {
            if (! $collection->contains($val)) {
                continue;
            }

            $matched++;

            if ($matched === 2) {
                return true;
            }
        }

        return false;
    }
}
