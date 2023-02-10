<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

abstract class StringEvaluator extends Evaluator
{
    public function __construct(
        protected readonly string $value,
    ) {
        //
    }
}
