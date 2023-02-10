<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Generic;

/**
 * Check if the field is equal to one of the values.
 */
class EqualsAnyEvaluator extends Evaluator
{
    public const NAME = 'equalsAny';

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
        return in_array($subject->scalar(), $this->value);
    }
}
