<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

abstract class IntEvaluator extends Evaluator
{
    public function __construct(
        protected int $value,
    ) {
    }
}
