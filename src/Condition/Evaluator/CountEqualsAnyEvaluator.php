<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Contracts\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Generic;

/**
 * Check count equals.
 */
class CountEqualsAnyEvaluator extends Evaluator
{
    public const NAME = 'countEqualsAny';

    /**
     * @param array<int> $value
     */
    public function __construct(
        #[Generic(Generic::OF_INTEGER)]
        private readonly array $value,
    ) {
        //
    }

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return in_array($subject->collection()->count(), $this->value, true);
    }
}
