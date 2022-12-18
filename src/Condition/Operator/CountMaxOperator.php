<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

class CountMaxOperator extends AbstractIntOperator
{
    public const NAME = 'countMax';

    protected function doEvaluate(MergeRequest $request): bool
    {
        return count($this->propertyExtractor->arrayable($request, $this->property)) <= $this->value;
    }
}
