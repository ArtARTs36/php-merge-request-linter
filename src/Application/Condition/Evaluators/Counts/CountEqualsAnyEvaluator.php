<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Evaluator;
use ArtARTs36\MergeRequestLinter\Common\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use function ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\in_array;

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
