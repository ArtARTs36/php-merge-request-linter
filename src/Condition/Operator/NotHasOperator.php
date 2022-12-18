<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Attribute\EvaluatesGenericType;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

#[EvaluatesGenericType]
class NotHasOperator extends AbstractScalarOperator
{
    public const NAME = 'not_has';

    protected function doEvaluate(MergeRequest $request): bool
    {
        return ! $this
            ->propertyExtractor
            ->iterable($request, $this->property)
            ->has($this->value);
    }
}
