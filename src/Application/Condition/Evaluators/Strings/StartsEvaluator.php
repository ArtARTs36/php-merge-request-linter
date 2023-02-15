<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

/**
 * Check if a string contains a prefix.
 */
class StartsEvaluator extends StringEvaluator
{
    public const NAME = 'starts';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->string()->startsWith("$this->value");
    }
}
