<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Application\Condition\Exceptions\EvaluatorCrashedException;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\Str\Exceptions\InvalidRegexException;
use ArtARTs36\Str\Facade\Str;

#[Description('Check if a string match a regex.')]
final class MatchEvaluator extends StringEvaluator
{
    public const NAME = 'match';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        try {
            return ! empty(Str::match($subject->interface(\ArtARTs36\Str\Str::class), $this->value));
        } catch (InvalidRegexException $e) {
            throw new EvaluatorCrashedException($e->getMessage(), previous: $e);
        }
    }
}
