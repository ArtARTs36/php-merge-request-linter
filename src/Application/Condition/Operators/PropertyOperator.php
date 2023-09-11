<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Operators;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubjectFactory;

class PropertyOperator implements ConditionOperator
{
    public function __construct(
        private readonly ConditionEvaluator $evaluator,
        private readonly EvaluatingSubjectFactory  $subjectFactory,
        private readonly string             $property,
    ) {
    }

    public function check(object $subject): bool
    {
        return $this->evaluator->evaluate($this->subjectFactory->createForProperty($subject, $this->property));
    }
}
