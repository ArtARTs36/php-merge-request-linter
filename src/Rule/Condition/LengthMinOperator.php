<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class LengthMinOperator extends AbstractIntOperator
{
    public const NAME = 'lengthMin';

    protected function doEvaluate(MergeRequest $request): bool
    {
        $val = $this->propertyExtractor->scalar($request, $this->property);

        return mb_strlen("$val") >= $this->value;
    }
}
