<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\Str\Facade\Str;

class EndsOperator extends AbstractScalarOperator implements ConditionOperator
{
    public const NAME = 'ends';

    protected function doEvaluate(MergeRequest $request): bool
    {
        $value = $this->propertyExtractor->scalar($request, $this->property);

        return Str::endsWith("$value", "$this->value");
    }
}
