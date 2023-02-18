<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

final class LinesMaxEvaluator extends IntEvaluator
{
    public const NAME = 'linesMax';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $this->value >= $subject->string()->linesCount();
    }
}
