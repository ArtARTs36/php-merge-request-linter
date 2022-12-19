<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\Str\Facade\Str;
use ArtARTs36\MergeRequestLinter\Contracts\EvaluatingSubject;

/**
 * Check the minimum string length.
 */
class LengthMinOperator extends IntEvaluator
{
    public const NAME = 'lengthMin';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        $val = $subject->scalar();

        return Str::length("$val") >= $this->value;
    }
}
