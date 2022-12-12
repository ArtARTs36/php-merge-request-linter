<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class LengthMaxOperator extends AbstractIntOperator
{
    public const NAME = 'lengthMax';

    protected function doEvaluate(MergeRequest $request): bool
    {
        $val = $this->propertyExtractor->scalar($request, $this->property);

        return mb_strlen("$val") <= $this->value;
    }
}
