<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition;

use ArtARTs36\MergeRequestLinter\Application\Condition\Operators\CompositeOperator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\OperatorResolver as OperatorResolverContract;

class OperatorResolver implements OperatorResolverContract
{
    public function __construct(
        private readonly OperatorFactory $operatorFactory,
    ) {
    }

    /**
     * @param array<string, array<string, scalar>> $when
     */
    public function resolve(array $when): ConditionOperator
    {
        $operators = [];
        $resolved = 0;

        foreach ($when as $field => $op) {
            foreach ($op as $operatorType => $value) {
                $operators[] = $this->operatorFactory->create($operatorType, $field, $value);
                ++$resolved;
            }
        }

        if ($resolved === 1 && ($firstOperator = reset($operators))) {
            return $firstOperator;
        }

        return new CompositeOperator($operators);
    }
}
