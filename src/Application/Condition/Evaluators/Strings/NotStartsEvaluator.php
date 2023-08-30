<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\Str\Str;

/**
 * Check if a string not contains a prefix.
 */
final class NotStartsEvaluator extends StringEvaluator
{
    public const NAME = 'notStarts';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return ! $subject->interface(Str::class)->startsWith($this->value);
    }
}
