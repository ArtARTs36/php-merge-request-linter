<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\Str\Facade\Str;

/**
 * Check if a string contains a prefix.
 */
class StartsOperator extends AbstractStringOperator implements ConditionOperator
{
    public const NAME = 'starts';

    protected function doEvaluate(MergeRequest $request): bool
    {
        $value = $this->propertyExtractor->string($request, $this->property);

        return Str::startsWith($value, "$this->value");
    }
}
