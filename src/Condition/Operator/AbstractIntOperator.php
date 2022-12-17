<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;

abstract class AbstractIntOperator extends AbstractOperator
{
    public function __construct(
        PropertyExtractor $propertyExtractor,
        string $property,
        protected int $value,
    ) {
        parent::__construct($propertyExtractor, $property);
    }
}
