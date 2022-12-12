<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class CountMaxOperator extends AbstractIntOperator
{
    public const NAME = 'countMax';

    protected function doEvaluate(MergeRequest $request): bool
    {
        return count($this->propertyExtractor->iterable($request, $this->property)) <= $this->value;
    }
}
