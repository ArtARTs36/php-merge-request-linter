<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

abstract class ScalarEvaluator extends Evaluator
{
    public function __construct(
        protected int|string|float|bool $value,
    ) {
        //
    }
}
