<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
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
