<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Contracts\Condition\ConditionOperator;

class OperatorResolver
{
    public function __construct(
        private readonly OperatorFactory $operatorFactory,
    ) {
        //
    }

    /**
     * @param array<string, array<string, scalar>> $when
     * @return iterable<ConditionOperator>
     */
    public function resolve(array $when): iterable
    {
        $operators = [];

        foreach ($when as $field => $op) {
            foreach ($op as $operatorType => $value) {
                $operators[] = $this->operatorFactory->create($operatorType, $field, $value);
            }
        }

        return $operators;
    }
}
