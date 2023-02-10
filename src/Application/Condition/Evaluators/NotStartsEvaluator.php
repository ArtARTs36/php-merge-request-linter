<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

/**
 * Check if a string not contains a prefix.
 */
class NotStartsEvaluator extends StringEvaluator
{
    public const NAME = 'notStarts';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return ! $subject->string()->startsWith("$this->value");
    }
}
