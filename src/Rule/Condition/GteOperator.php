<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class GteOperator extends AbstractOperator implements ConditionOperator
{
    public const NAME = 'gte';
    public const SYMBOL = '>=';

    public function __construct(
        PropertyExtractor $propertyExtractor,
        private string $property,
        private int|float $value,
    ) {
        parent::__construct($propertyExtractor);
    }

    protected function doEvaluate(MergeRequest $request): bool
    {
        return $this
            ->propertyExtractor
            ->numeric($request, $this->property) >= $this->value;
    }
}
