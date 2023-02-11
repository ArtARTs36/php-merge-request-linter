<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Iter\AllEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Operators\PropertyOperator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\ConditionEvaluatorNotFound;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\PropertyExtractor;

class OperatorFactory
{
    public function __construct(
        private readonly PropertyExtractor $propertyExtractor,
        private readonly EvaluatorFactory $evaluatorFactory,
    ) {
        //
    }

    /**
     * @throws ConditionEvaluatorNotFound
     */
    public function create(string $type, string $field, mixed $value): ConditionOperator
    {
        if ($type === '$all' && is_array($value)) {
            $evaluators = [];

            foreach ($value as $evName => $val) {
                $evaluators[] = $this->evaluatorFactory->create($evName, $val);
            }

            return new PropertyOperator(
                new AllEvaluator($evaluators),
                $this->propertyExtractor,
                $field,
            );
        }

        $evaluator = $this->evaluatorFactory->create($type, $value);

        return new PropertyOperator($evaluator, $this->propertyExtractor, $field);
    }
}
