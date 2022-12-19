<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

abstract class NumberEvaluator extends Evaluator
{
    public function __construct(
        protected readonly int|float $value,
    ){
        //
    }
}
