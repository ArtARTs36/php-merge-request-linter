<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Condition\Attribute\EvaluatesGenericType;
use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

/**
 * Check if an array contains some value.
 */
#[EvaluatesGenericType]
class HasOperator extends AbstractScalarOperator implements ConditionOperator
{
    public const NAME = 'has';

    protected function doEvaluate(MergeRequest $request): bool
    {
        return $this
            ->propertyExtractor
            ->arrayable($request, $this->property)
            ->has($this->value);
    }
}
