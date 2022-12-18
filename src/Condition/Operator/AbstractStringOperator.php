<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

abstract class AbstractStringOperator extends AbstractOperator
{
    public function __construct(
        PropertyExtractor $propertyExtractor,
        string $property,
        protected string $value,
    ) {
        parent::__construct($propertyExtractor, $property);
    }

    protected function getPropertyValue(MergeRequest $request): string
    {
        return $this->propertyExtractor->string($request, $this->property);
    }
}
