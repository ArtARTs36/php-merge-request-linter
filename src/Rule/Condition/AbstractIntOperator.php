<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

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
