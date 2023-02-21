<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Collection;

/**
 * Check if an array contains some value of list.
 */
class HasAnyEvaluator extends Evaluator
{
    public const NAME = 'hasAny';

    /**
     * @param array<scalar> $value
     */
    public function __construct(
        #[Generic(Generic::OF_STRING)]
        private readonly array $value,
    ) {
        //
    }

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject
            ->interface(Collection::class)
            ->containsAny($this->value);
    }
}
