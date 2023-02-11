<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

/**
 * Check if a string is studly case.
 */
class IsStudlyCaseEvaluator extends BoolEvaluator
{
    public const NAME = 'isStudlyCase';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->string()->isStudlyCaps() === $this->value;
    }
}
