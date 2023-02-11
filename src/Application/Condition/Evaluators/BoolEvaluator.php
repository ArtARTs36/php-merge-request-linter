<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

abstract class BoolEvaluator extends Evaluator
{
    public function __construct(
        protected readonly bool $value,
    ) {
        //
    }
}
