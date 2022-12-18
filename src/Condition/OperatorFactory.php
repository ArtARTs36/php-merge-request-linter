<?php

namespace ArtARTs36\MergeRequestLinter\Condition;

use ArtARTs36\MergeRequestLinter\Condition\Operator\AbstractOperator;
use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Exception\ConditionOperatorNotFound;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Support\CallbackPropertyExtractor;

class OperatorFactory
{
    /**
     * @param Map<string, class-string<AbstractOperator>> $operatorByType
     */
    public function __construct(
        private readonly Map                       $operatorByType,
        private readonly CallbackPropertyExtractor $propertyExtractor,
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
