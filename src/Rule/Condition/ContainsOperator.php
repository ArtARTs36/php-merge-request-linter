<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class ContainsOperator extends AbstractScalarOperator
{
    public const NAME = 'contains';

    protected function doEvaluate(MergeRequest $request): bool
    {
        $val = $this->getPropertyValue($request);

        return str_contains("$val", "$this->value");
    }
}
