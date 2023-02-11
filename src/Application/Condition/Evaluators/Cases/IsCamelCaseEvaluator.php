<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Cases;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\BoolEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

/**
 * Check if a string is camelCase.
 */
class IsCamelCaseEvaluator extends BoolEvaluator
{
    public const NAME = 'isCamelCase';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->string()->isCamelCase() === $this->value;
    }
}
