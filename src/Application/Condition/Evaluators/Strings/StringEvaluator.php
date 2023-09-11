<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Evaluator;

abstract class StringEvaluator extends Evaluator
{
    public function __construct(
        protected readonly string $value,
    ) {
    }
}
