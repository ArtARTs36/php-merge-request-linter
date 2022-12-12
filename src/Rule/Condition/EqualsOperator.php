<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;

class EqualsOperator extends AbstractOperator implements ConditionOperator
{
    public const NAME = 'equals';
    public const SYMBOL = '=';

    public function __construct(
        PropertyExtractor $propertyExtractor,
        string $property,
        private readonly mixed $equals,
    ) {
        parent::__construct($propertyExtractor, $property);
    }

    protected function doEvaluate(MergeRequest $request): bool
    {
        return $this->propertyExtractor->scalar($request, $this->property) === $this->equals;
    }
}
