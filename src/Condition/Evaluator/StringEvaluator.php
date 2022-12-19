<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

abstract class StringEvaluator extends Evaluator
{
    public function __construct(
        protected readonly string $value,
    ) {
        //
    }
}
