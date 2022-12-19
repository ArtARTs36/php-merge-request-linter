<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Condition\Evaluator\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Contracts\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;

class PropertyOperator implements ConditionOperator
{
    public function __construct(
        private readonly ConditionEvaluator $operator,
        private readonly PropertyExtractor  $propertyExtractor,
        private readonly string             $property,
    ) {
        //
    }

    public function evaluate(object $subject): bool
    {
        return $this->operator->evaluate(new EvaluatingSubject(
            $subject,
            $this->propertyExtractor,
            $this->property,
        ));
    }
}
