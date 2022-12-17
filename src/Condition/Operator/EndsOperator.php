<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\Str\Facade\Str;

class EndsOperator extends AbstractStringOperator implements ConditionOperator
{
    public const NAME = 'ends';

    protected function doEvaluate(MergeRequest $request): bool
    {
        $value = $this->propertyExtractor->string($request, $this->property);

        return Str::endsWith($value, "$this->value");
    }
}
