<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

final class ContainsLineEvaluator extends StringEvaluator
{
    public const NAME = 'containsAny';

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject->string()->hasLine($this->value);
    }
}
