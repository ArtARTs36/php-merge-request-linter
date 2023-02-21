<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\Str\Str;

/**
 * Check if a string contains a suffix.
 */
class EndsEvaluator extends StringEvaluator
{
    public const NAME = 'ends';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->interface(Str::class)->endsWith("$this->value");
    }
}
