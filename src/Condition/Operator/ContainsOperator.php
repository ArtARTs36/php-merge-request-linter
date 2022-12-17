<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\Str\Facade\Str;

class ContainsOperator extends AbstractStringOperator
{
    public const NAME = 'contains';

    protected function doEvaluate(MergeRequest $request): bool
    {
        $val = $this->getPropertyValue($request);

        return Str::contains("$val", "$this->value");
    }
}
