<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Exception\ConditionOperatorNotFound;
use ArtARTs36\MergeRequestLinter\Support\Map;

class OperatorFactory
{
    /**
     * @param Map<string, class-string<ConditionOperator>> $operatorByType
     */
    public function __construct(
        private readonly Map $operatorByType,
        private readonly PropertyExtractor   $propertyExtractor,
    ) {
        //
    }

    /**
     * @throws ConditionOperatorNotFound
     */
    public function create(string $type, string $field, mixed $value): ConditionOperator
    {
        $class = $this->operatorByType->get($type);

        if ($class === null) {
            throw ConditionOperatorNotFound::make($type);
        }

        return new $class(
            $this->propertyExtractor,
            $field,
            $value,
        );
    }
}
