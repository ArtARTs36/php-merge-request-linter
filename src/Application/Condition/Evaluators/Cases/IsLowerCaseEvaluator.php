<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Cases;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\BoolEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

/**
 * Check if a string is lower case.
 */
class IsLowerCaseEvaluator extends BoolEvaluator
{
    public const NAME = 'isLowerCase';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->string()->isLower() === $this->value;
    }
}
