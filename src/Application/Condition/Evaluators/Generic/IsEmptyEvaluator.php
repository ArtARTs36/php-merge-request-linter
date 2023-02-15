<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Generic;

use ArtARTs36\EmptyContracts\MayBeEmpty;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\BoolEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

/**
 * Check if a value is empty.
 */
final class IsEmptyEvaluator extends BoolEvaluator
{
    public const NAME = 'isEmpty';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->interface(MayBeEmpty::class)->isEmpty() === $this->value;
    }
}
