<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\BoolEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

/**
 * Check if a string is snake_case.
 */
class IsSnakeCaseEvaluator extends BoolEvaluator
{
    public const NAME = 'isSnakeCase';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->string()->isSnakeCase() === $this->value;
    }
}
