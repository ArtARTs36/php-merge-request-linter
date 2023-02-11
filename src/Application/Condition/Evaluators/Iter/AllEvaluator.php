<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Iter;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\StaticEvaluatingSubject;

class AllEvaluator implements ConditionEvaluator
{
    /**
     * @param iterable<ConditionEvaluator> $evaluators
     */
    public function __construct(
        private readonly iterable $evaluators,
    ) {
        //
    }

    public function evaluate(EvaluatingSubject $subject): bool
    {
        foreach ($subject->collection() as $value) {
            foreach ($this->evaluators as $evaluator) {
                if (! $evaluator->evaluate(new StaticEvaluatingSubject($value))) {
                    return false;
                }
            }
        }

        return true;
    }
}
