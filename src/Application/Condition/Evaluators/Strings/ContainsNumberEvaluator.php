<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\BoolEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Evaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\Str\Str;

#[Description('Check if value are contains number.')]
final class ContainsNumberEvaluator extends BoolEvaluator
{
    public const NAME = 'containsNumber';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->interface(Str::class)->containsDigit() === $this->value;
    }
}
