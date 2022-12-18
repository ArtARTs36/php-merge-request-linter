<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

/**
 * Check the minimum number of elements in a field.
 */
class CountMinOperator extends AbstractIntOperator
{
    public const NAME = 'countMin';

    protected function doEvaluate(MergeRequest $request): bool
    {
        return count($this->propertyExtractor->arrayable($request, $this->property)) >= $this->value;
    }
}
