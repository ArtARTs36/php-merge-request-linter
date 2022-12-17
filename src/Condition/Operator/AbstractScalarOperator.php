<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

abstract class AbstractScalarOperator extends AbstractOperator
{
    public function __construct(
        PropertyExtractor $propertyExtractor,
        string $property,
        protected int|string|float|bool $value,
    ) {
        parent::__construct($propertyExtractor, $property);
    }

    protected function getPropertyValue(MergeRequest $request): int|string|float|bool
    {
        return $this->propertyExtractor->scalar($request, $this->property);
    }
}
