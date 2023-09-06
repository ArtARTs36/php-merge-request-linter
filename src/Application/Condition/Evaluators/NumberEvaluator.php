<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

abstract class NumberEvaluator extends Evaluator
{
    public function __construct(
        protected readonly int|float $value,
    ) {
    }
}
