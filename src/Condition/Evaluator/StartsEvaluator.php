<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Contracts\Condition\EvaluatingSubject;
use ArtARTs36\Str\Facade\Str;

/**
 * Check if a string contains a prefix.
 */
class StartsEvaluator extends StringEvaluator
{
    public const NAME = 'starts';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return Str::startsWith($subject->string(), "$this->value");
    }
}
