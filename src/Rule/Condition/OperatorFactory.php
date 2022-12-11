<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;

class OperatorFactory
{
    private const MAP = [
        EqualsOperator::NAME => EqualsOperator::class,
        StartsOperator::NAME => StartsOperator::class,
        ContainsOperator::NAME => ContainsOperator::class,
        EndsOperator::NAME => EndsOperator::class,
    ];

    private PropertyExtractor $propertyExtractor;

    public function __construct(
        ?PropertyExtractor $propertyExtractor,
    ) {
        $this->propertyExtractor = $propertyExtractor ?? new PropertyExtractor();
    }

    public function create(string $type, string $field, string $value): ConditionOperator
    {
        $class = self::MAP[$type];

        return new $class(
            $this->propertyExtractor,
            $field,
            $value,
        );
    }

    public function createEqualsOperator(string $field, mixed $value): ConditionOperator
    {
        return new EqualsOperator($this->propertyExtractor, $field, $value);
    }
}
