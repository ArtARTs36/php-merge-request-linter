<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Attribute\EvaluatesGenericType;
use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

#[EvaluatesGenericType]
class HasOperator extends AbstractOperator implements ConditionOperator
{
    public const NAME = 'has';

    public function __construct(
        PropertyExtractor $propertyExtractor,
        string $property,
        private int|string|float|bool $value,
    ) {
        parent::__construct($propertyExtractor, $property);
    }

    protected function doEvaluate(MergeRequest $request): bool
    {
        return $this
            ->propertyExtractor
            ->iterable($request, $this->property)
            ->has($this->value);
    }
}
