<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\Str\Facade\Str;

/**
 * Check if a string contains a substring.
 */
class ContainsEvaluator extends StringEvaluator
{
    public const NAME = 'contains';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        $val = $subject->scalar();

        return Str::contains("$val", "$this->value");
    }
}
