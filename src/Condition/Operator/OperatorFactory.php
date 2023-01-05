<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Condition\Evaluator\EvaluatorFactory;
use ArtARTs36\MergeRequestLinter\Contracts\Condition\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;
use ArtARTs36\MergeRequestLinter\Exception\ConditionEvaluatorNotFound;

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
        $evaluator = $this->evaluatorFactory->create($type, $value);

        return new PropertyOperator($evaluator, $this->propertyExtractor, $field);
    }
}
