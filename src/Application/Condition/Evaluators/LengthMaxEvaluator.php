<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\Str\Facade\Str;

/**
 * Check the maximum string length.
 */
class LengthMaxEvaluator extends IntEvaluator
{
    public const NAME = 'lengthMax';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        $val = $subject->scalar();

        return Str::length("$val") <= $this->value;
    }
}
