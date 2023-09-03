<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\BoolEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\Str\Str;

#[Description('Check if a string is lower case.')]
final class IsLowerCaseEvaluator extends BoolEvaluator
{
    public const NAME = 'isLowerCase';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->interface(Str::class)->isLower() === $this->value;
    }
}
