<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Support\Map;

class OperatorFactory
{
    private PropertyExtractor $propertyExtractor;

    /**
     * @param Map<string, class-string<ConditionOperator>> $operatorByType
     * @param PropertyExtractor|null $propertyExtractor
     */
    public function __construct(
        private readonly Map $operatorByType,
        ?PropertyExtractor   $propertyExtractor,
    ) {
        $this->propertyExtractor = $propertyExtractor ?? new PropertyExtractor();
    }

    public function create(string $type, string $field, string $value): ConditionOperator
    {
        $class = $this->operatorByType->get($type);

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
