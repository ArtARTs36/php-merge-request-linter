<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\Str\Str;

/**
 * Check the maximum string lines.
 */
final class LinesMaxEvaluator extends IntEvaluator
{
    public const NAME = 'linesMax';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $this->value >= $subject->interface(Str::class)->linesCount();
    }
}
