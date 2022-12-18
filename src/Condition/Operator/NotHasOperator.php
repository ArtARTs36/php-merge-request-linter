<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Condition\Attribute\EvaluatesGenericType;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

/**
 * Check if an array not contains some value.
 */
#[EvaluatesGenericType]
class NotHasOperator extends AbstractScalarOperator
{
    public const NAME = 'notHas';

    protected function doEvaluate(MergeRequest $request): bool
    {
        return ! $this
            ->propertyExtractor
            ->arrayable($request, $this->property)
            ->has($this->value);
    }
}
