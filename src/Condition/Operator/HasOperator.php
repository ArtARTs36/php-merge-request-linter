<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Attribute\EvaluatesGenericType;
use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

#[EvaluatesGenericType]
class HasOperator extends AbstractScalarOperator implements ConditionOperator
{
    public const NAME = 'has';

    protected function doEvaluate(MergeRequest $request): bool
    {
        return $this
            ->propertyExtractor
            ->iterable($request, $this->property)
            ->has($this->value);
    }
}
