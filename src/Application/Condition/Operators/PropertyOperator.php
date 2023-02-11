<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Operators;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\PropertyEvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\PropertyExtractor;

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
        return $this->evaluator->evaluate(new PropertyEvaluatingSubject(
            $subject,
            $this->propertyExtractor,
            $this->property,
        ));
    }
}
