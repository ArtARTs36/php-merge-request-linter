<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\Str\Str;

/**
 * Check if a string contains a line.
 */
final class ContainsLineEvaluator extends StringEvaluator
{
    public const NAME = 'containsLine';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->interface(Str::class)->hasLine($this->value);
    }
}
