<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Contracts\Condition\EvaluatingSubject;
use ArtARTs36\Str\Facade\Str;

/**
 * Check if a string not contains a suffix.
 */
class NotEndsEvaluator extends StringEvaluator
{
    public const NAME = 'notEnds';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return ! Str::endsWith($subject->string(), "$this->value");
    }
}
