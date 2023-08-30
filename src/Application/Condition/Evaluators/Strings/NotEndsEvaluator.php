<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\Str\Str;

/**
 * Check if a string not contains a suffix.
 */
final class NotEndsEvaluator extends StringEvaluator
{
    public const NAME = 'notEnds';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return ! $subject->interface(Str::class)->endsWith("$this->value");
    }
}
