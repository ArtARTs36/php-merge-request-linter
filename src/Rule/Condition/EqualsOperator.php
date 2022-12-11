<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class EqualsOperator implements ConditionOperator
{
    public function __construct(
        private PropertyExtractor $propertyExtractor,
        private readonly string $property,
        private readonly mixed $equals,
    ) {
        //
    }

    public function evaluate(MergeRequest $request): bool
    {
        return $this->propertyExtractor->scalar($request, $this->property) === $this->equals;
    }
}
