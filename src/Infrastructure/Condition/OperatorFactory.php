<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition;

use ArtARTs36\MergeRequestLinter\Application\Condition\Operators\PropertyOperator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubjectFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\ConditionEvaluatorNotFound;

class OperatorFactory
{
    public function __construct(
        private readonly EvaluatingSubjectFactory $subjectFactory,
        private readonly EvaluatorFactory         $evaluatorFactory,
    ) {
    }

    /**
     * @throws ConditionEvaluatorNotFound
     */
    public function create(string $type, string $field, mixed $value): ConditionOperator
    {
        $evaluator = $this->evaluatorFactory->create($type, $value);

        return new PropertyOperator($evaluator, $this->subjectFactory, $field);
    }
}
