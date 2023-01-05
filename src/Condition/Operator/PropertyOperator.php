<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Condition\Evaluator\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Contracts\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Contracts\Condition\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;

class PropertyOperator implements ConditionOperator
{
    public function __construct(
        private readonly ConditionEvaluator $evaluator,
        private readonly PropertyExtractor  $propertyExtractor,
        private readonly string             $property,
    ) {
        //
    }

    public function check(object $subject): bool
    {
        return $this->evaluator->evaluate(new EvaluatingSubject(
            $subject,
            $this->propertyExtractor,
            $this->property,
        ));
    }
}
