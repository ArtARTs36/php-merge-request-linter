<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;

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
