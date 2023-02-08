<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Contracts\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Exception\InvalidEvaluatorValueException;
use ArtARTs36\Str\Exceptions\InvalidRegexException;
use ArtARTs36\Str\Facade\Str;

/**
 * Check if a string match a regex.
 */
class MatchEvaluator extends StringEvaluator
{
    public const NAME = 'match';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        try {
            return ! empty(Str::match($subject->string(), $this->value));
        } catch (InvalidRegexException $e) {
            throw new InvalidEvaluatorValueException($e->getMessage(), previous: $e);
        }
    }
}
