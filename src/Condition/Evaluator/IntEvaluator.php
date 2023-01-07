<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

abstract class IntEvaluator extends Evaluator
{
    public function __construct(
        protected int $value,
    ) {
        //
    }
}
