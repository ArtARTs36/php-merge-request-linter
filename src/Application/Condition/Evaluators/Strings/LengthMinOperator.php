<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\IntEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\Str\Facade\Str;

#[Description('Check the minimum string length.')]
final class LengthMinOperator extends IntEvaluator
{
    public const NAME = 'lengthMin';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        $val = $subject->scalar();

        return Str::length("$val") >= $this->value;
    }
}
