<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

/**
 * Check if a string is empty.
 */
final class IsEmptyEvaluator extends Evaluator
{
    public const NAME = 'isEmpty';

    public function __construct(
        private readonly bool $value,
    ) {
        //
    }

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return ($subject->string() === '') === $this->value;
    }
}
