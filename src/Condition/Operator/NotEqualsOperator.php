<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

class NotEqualsOperator extends AbstractOperator implements ConditionOperator
{
    public const NAME = 'not_equals';
    public const SYMBOL = '!=';

    public function __construct(
        PropertyExtractor $propertyExtractor,
        string $property,
        private readonly mixed $equals,
    ) {
        parent::__construct($propertyExtractor, $property);
    }

    protected function doEvaluate(MergeRequest $request): bool
    {
        return $this->propertyExtractor->scalar($request, $this->property) !== $this->equals;
    }
}
