<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\Str\Facade\Str;

class StartsOperator extends AbstractScalarOperator implements ConditionOperator
{
    public const NAME = 'starts';

    protected function doEvaluate(MergeRequest $request): bool
    {
        $value = $this->propertyExtractor->scalar($request, $this->property);

        return Str::startsWith("$value", $this->value);
    }
}
