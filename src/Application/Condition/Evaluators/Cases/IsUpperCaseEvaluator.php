<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Cases;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\BoolEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

/**
 * Check if a string is upper case.
 */
class IsUpperCaseEvaluator extends BoolEvaluator
{
    public const NAME = 'isUpperCase';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->string()->isUpper() === $this->value;
    }
}
