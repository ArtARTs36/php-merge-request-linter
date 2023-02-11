<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Cases;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\BoolEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

/**
 * Check if a string is kebab case.
 */
class IsKebabCaseEvaluator extends BoolEvaluator
{
    public const NAME = 'isKebabCase';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->string()->isKebabCase() === $this->value;
    }
}
