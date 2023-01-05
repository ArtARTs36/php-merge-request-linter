<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Contracts\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Generic;

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
            ->collection()
            ->containsAny($this->value);
    }
}
