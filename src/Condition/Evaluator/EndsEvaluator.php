<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Contracts\EvaluatingSubject;
use ArtARTs36\Str\Facade\Str;

/**
 * Check if a string contains a suffix.
 */
class EndsEvaluator extends StringEvaluator
{
    public const NAME = 'ends';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return Str::endsWith($subject->string(), "$this->value");
    }
}
