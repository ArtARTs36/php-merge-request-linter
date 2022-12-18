<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Condition\Attribute\EvaluatesSameType;
use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

/**
 * Check if a number is greater than or less than.
 */
#[EvaluatesSameType]
class GteOperator extends AbstractOperator implements ConditionOperator
{
    public const NAME = 'gte';
    public const SYMBOL = '>=';

    public function __construct(
        PropertyExtractor $propertyExtractor,
        string $property,
        private int|float $value,
    ) {
        parent::__construct($propertyExtractor, $property);
    }

    protected function doEvaluate(MergeRequest $request): bool
    {
        return $this
            ->propertyExtractor
            ->numeric($request, $this->property) >= $this->value;
    }
}
