<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Composite;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubjectFactory;

abstract class CompositeEvaluator implements ConditionEvaluator
{
    /**
     * @param iterable<ConditionEvaluator> $value
     */
    public function __construct(
        protected readonly iterable $value,
        protected readonly EvaluatingSubjectFactory $subjectFactory,
    ) {
        //
    }
}
