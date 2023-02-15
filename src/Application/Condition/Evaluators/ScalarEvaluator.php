<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

abstract class ScalarEvaluator extends Evaluator
{
    public function __construct(
        protected int|string|float|bool $value,
    ) {
        //
    }
}
