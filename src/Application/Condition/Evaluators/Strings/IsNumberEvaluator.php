<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\BoolEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\Str\Str;

#[Description('Check if value are number.')]
final class IsNumberEvaluator extends BoolEvaluator
{
    public const NAME = 'isNumber';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->interface(Str::class)->isDigit() === $this->value;
    }
}
