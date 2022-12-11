<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

abstract class AbstractOperator implements ConditionOperator
{
    abstract protected function doEvaluate(MergeRequest $request): bool;

    public function __construct(
        protected PropertyExtractor $propertyExtractor,
    ) {
        //
    }

    public function evaluate(MergeRequest $request): bool
    {
       return $this->doEvaluate($request);
    }
}
