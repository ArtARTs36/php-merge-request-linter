<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\BoolEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\Str\Str;

/**
 * Check if a string is upper case.
 */
class IsUpperCaseEvaluator extends BoolEvaluator
{
    public const NAME = 'isUpperCase';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->interface(Str::class)->isUpper() === $this->value;
    }
}
