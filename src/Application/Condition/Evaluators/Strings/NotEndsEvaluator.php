<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

/**
 * Check if a string not contains a suffix.
 */
class NotEndsEvaluator extends StringEvaluator
{
    public const NAME = 'notEnds';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return ! $subject->string()->endsWith("$this->value");
    }
}
