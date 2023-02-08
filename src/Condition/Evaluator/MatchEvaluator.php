<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Contracts\Condition\EvaluatingSubject;
use ArtARTs36\Str\Facade\Str;

/**
 * Check if a string match a regex.
 */
class MatchEvaluator extends StringEvaluator
{
    public const NAME = 'match';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return Str::match($subject->string(), $this->value);
    }
}
