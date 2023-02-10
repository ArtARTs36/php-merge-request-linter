<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

/**
 * Check if a string contains a suffix.
 */
class EndsEvaluator extends StringEvaluator
{
    public const NAME = 'ends';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->string()->endsWith("$this->value");
    }
}
