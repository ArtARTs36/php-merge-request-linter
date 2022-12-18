<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Condition\Attribute\EvaluatesSameType;
use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

/**
 * Check if value are not equal.
 */
#[EvaluatesSameType]
class NotEqualsOperator extends AbstractOperator implements ConditionOperator
{
    public const NAME = 'notEquals';
    public const SYMBOL = '!=';

    public function __construct(
        PropertyExtractor      $propertyExtractor,
        string                 $property,
        private readonly int|float|string|bool $value,
    ) {
        parent::__construct($propertyExtractor, $property);
    }

    protected function doEvaluate(MergeRequest $request): bool
    {
        return $this->propertyExtractor->scalar($request, $this->property) !== $this->value;
    }
}
