<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

class CountMinOperator extends AbstractIntOperator
{
    public const NAME = 'countMin';

    protected function doEvaluate(MergeRequest $request): bool
    {
        return count($this->propertyExtractor->iterable($request, $this->property)) >= $this->value;
    }
}
