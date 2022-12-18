<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\Str\Facade\Str;

/**
 * Check the maximum string length.
 */
class LengthMaxOperator extends AbstractIntOperator
{
    public const NAME = 'lengthMax';

    protected function doEvaluate(MergeRequest $request): bool
    {
        $val = $this->propertyExtractor->scalar($request, $this->property);

        return Str::length("$val") <= $this->value;
    }
}
