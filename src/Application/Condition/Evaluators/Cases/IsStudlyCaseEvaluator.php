<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Cases;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\BoolEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

/**
 * Check if a string is StudlyCase.
 */
class IsStudlyCaseEvaluator extends BoolEvaluator
{
    public const NAME = 'isStudlyCase';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->string()->isStudlyCaps() === $this->value;
    }
}
